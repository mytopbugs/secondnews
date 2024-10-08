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
     * Тут можно было ещё исключение выкинуть, когда не те параметры, но для задачи счёл излишним
     * @param  Request  $request
     * @return JsonResponse|null
     * @throws InvalidParamException
     */
    public function index (Request $request): ?JsonResponse {

        $existSlug = $request->has($this->slug);
        $existPage = $request->has($this->page);

        if ($existSlug) {
            $id = intval($request->get($this->slug));

            return $this->getNewsItem($id);
        } elseif ($existPage) {

            return $this->getNewsList();
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
            $this->updateItem($item);
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
     * @return JsonResponse
     */
    public function getNewsList(): JsonResponse
    {
        $news = News::paginate($this->cntItemsPerPage);

        $news = $news->each(function ($item) {
            $this->updateListItem($item);
            $this->createLink($item);
        });

        return response()->json( $news );
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
     * @param  News  $item
     * @return void
     */
    private function updateItem (News $item): void {
        $item->makeHidden('id', 'preview', 'preview_img');
    }

    /**
     * @param  News  $item
     * @return void
     */
    private function updateListItem (News $item): void {
        $item->makeHidden('id', 'content', 'content_img', 'recommend_list');
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
