<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Можно и грамотнее, но акцент на генерации демо данных я не делал
        $imgStr = fake()->text(5);
        $imgNum = rand(0, 500);

        $prev = sprintf('/%s_%d.jpg', $imgStr, $imgNum);
        $content = sprintf('/%s_%d.jpg', $imgStr, $imgNum);

        $int = rand(1262055681,1262055681);
        $dateTime = date("Y-m-d H:i:s",$int);

        $recomended = array(
            [], [1,5,8], [], [4], [34, 12]
        );

        return [
            'create_time' => fake()->dateTime($max = 'now', $timezone = null),
            'title' => fake('ru_RU')->text(10),
            'preview' => fake()->text(25),
            'content' => fake('ru_RU')->sentence(),
            'preview_img' => sprintf('/img/preview%s', $prev),
            'content_img' => sprintf('/img/content%s', $content),
            'author' => fake('ru_RU')->name(),
            'recommend_list' => json_encode(fake()->randomElement($recomended)),
        ];
    }
}
