<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


/**
 * Шаг для пагинатора я взял равным 10 и поэтому не кратное количество новостей добавил
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        News::truncate();

        // Чтоб не было новостей ссылающихся на себя. Можно было просто удалить из списка рекомендованных текущий id
        News::factory(101)
            ->create()
            ->each(function(News $news) {
                $attr = json_decode($news->getAttribute('recommend_list'), true);

                if (in_array($news->getKey(), $attr))
                {
                    DB::table('news')
                        ->where('id', $news->getKey())
                        ->update(['recommend_list' => '[]']);
                }
            });
    }
}
