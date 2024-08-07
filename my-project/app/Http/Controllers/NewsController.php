<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Exceptions\InvalidParamException;

class NewsController extends Controller
{
    /**
     * @var int
     */
    private int $cntItemsPerPage = 10;

    /**
     * Добавил для надёжного контроля
     * @var string
     */
    private string $slug = 'slug';

    /**
     * Добавил для более надёжного контроля
     * @var string
     */
    private string $page = 'page';

    /**
     * @var array|string[]
     */
    private array $fieldsListItem = [
        'id',
        'title',
        'create_time',
        'preview',
        'preview_img',
        'author',
    ];

    /**
     * @var int
     */
    private int $pageItems = 10;

    /**
     * Тут можно было ещё исключение выкинуть, когда не те параметры, но для задачи счёл излишним
     * @param  Request  $request
     * @return JsonResponse|null
     * @throws InvalidParamException
     */
    public function getNews (Request $request): ?JsonResponse {

        $existSlug = $request->has($this->slug);
        $existPage = $request->has($this->page);

        if ($existSlug) {
            $id = intval($request->get($this->slug));

            return $this->getNewsItem($id);
        } elseif ($existPage) {
            $page = intval($request->get($this->page));

            return $this->getNewsList($page);
        } else {

            return null;
        }
    }

    /**
     * Я специально оставил recommend_list с null, когда там ничего нет
     * @param  int  $id
     * @return JsonResponse|null
     * @throws InvalidParamException
     */
    private function getNewsItem(int $id): ?JsonResponse
    {
        $news = News::all();
        $item = $news->find($id);

        if ($item instanceof News) {
            $item = $this->updateItem($item);
            $list        = json_decode($item->getAttribute('recommend_list'), true);
            $listUpdated = $this->updateList($news, $list);
            $item->setAttribute('recommend_list', $listUpdated);

            return response()->json( $item );
        }
    else {
        throw new InvalidParamException('Страница не существует');
        }
    }

    /**
     * @param  int  $pageNum
     * @return JsonResponse
     * @throws InvalidParamException
     */
    public function getNewsList(int $pageNum): JsonResponse
    {
        if ($pageNum < 1) {
            throw new InvalidParamException('Страница должна быть больше 0');
        }

        $news = News::all($this->fieldsListItem);
        $news = $this->addLinkItem($news);

        $news = $news->each(function ($item) {
            $this->fieldsFlip($item);
        });

        $newsArr  = $news->toArray();
        $padeData = array_slice($newsArr, --$pageNum * $this->pageItems, $this->cntItemsPerPage);

        if ( count($padeData) == 0) {
            throw new InvalidParamException('Страница вне диапазона');
        }

        return response()->json( $padeData );
    }

    /**
     * @param Collection $news
     * @param array $list
     * @return array|null
     */
    private function updateList(Collection $news, array $list): ?array
    {
        $items = null;
        foreach ($list as $id) {
            $subItem = $news->find($id);

            $subItem->makeHidden('id', 'content', 'content_img', 'recommend_list');
            $subItem = $this->createLink($subItem);

            $items[] = $subItem;
        }

        return $items;
    }

    /**
     * @param  Collection  $news
     * @return Collection
     */
    private function addLinkItem(Collection $news): Collection
    {
        return $news->each(function ($item) {

            $item = $this->createLink($item);
            $item->makeHidden('id');

        });
    }

    /**
     * @param  News  $item
     * @return News
     */
    private function updateItem (News $item): News {
        $item->makeHidden('id', 'preview', 'preview_img');

        return $item;
    }

    /**
     * @param  News  $item
     * @return News
     */
    private function createLink(News $item): News {
        $itemURL = sprintf('/api/news/?%s=%d', $this->slug, $item->getAttribute('id'));
        $item->setAttribute('linkURL', $itemURL);
        $this->fieldsFlip($item);

        return $item;
    }

    /**
     * Может это и не надо делать, но мне показалось, что на этом сделан акцент
     * @param  News  $item
     * @return void
     */
    private function fieldsFlip(News $item): void {
        $item->setAttribute('creator', $item->getAttribute('author'));
        unset($item->author);
        $item->setAttribute('author', $item->getAttribute('creator'));
        unset($item->creator);
    }
}
