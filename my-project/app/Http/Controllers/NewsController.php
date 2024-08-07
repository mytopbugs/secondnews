<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

class NewsController extends Controller
{
    /**
     * @var array|string[]
     */
    private array $fieldsList = [
        "id",
        "create_time",
        "title",
        "preview",
        "content",
        "preview_img",
        "content_img",
        "author",
    ];

    /**
     * @var int
     */
    private int $pageItems = 10;

    /**
     * @param int $id
     * @return JsonResponse|null
     */
    public function getNewsItem(int $id): ?JsonResponse
    {
        $news = News::all();
        $item = $news->find($id);

        if ($item instanceof News) {
            $list        = json_decode($item->getAttribute('recommend_list'), true);
            $listUpdated = $this->updateList($news, $list);
            $item->setAttribute('recommend_list', $listUpdated);

            return response()->json( $item );
        }
    else {
        return response()->json( null );
        }
    }

    /**
     * @param int $pageNum
     * @return JsonResponse
     */
    public function getNewsList(int $pageNum): JsonResponse
    {
        $news     = News::all($this->fieldsList);
        $newsArr  = $news->toArray();
        $padeData = array_slice($newsArr, --$pageNum * $this->pageItems, 10);

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
            $subItem = $news->find($id)->toArray();
            //TODO Заменить!
            unset($subItem['recommend_list']);
            $items[] = $subItem;
        }

        return $items;
    }
}
