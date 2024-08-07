<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imgStr  = fake()->text(5);
        $imgNum  = rand(0, 500);
        $prev    = sprintf('/%s_%d.jpg', $imgStr, $imgNum);
        $content = sprintf('/%s_%d.jpg', $imgStr, $imgNum);

        $recommend = array(
            [12,11,33], [1,5,8], [15,20,40], [4], [34, 12], [], [], [3,65]
        );

        return [
            'create_time' => fake()->dateTime(),
            'title' => fake()->text(10),
            'preview' => fake()->text(25),
            'content' => fake()->sentence(),
            'preview_img' => sprintf('/img/preview%s', $prev),
            'content_img' => sprintf('/img/content%s', $content),
            'author' => fake('ru_RU')->name(),
            'recommend_list' => json_encode(fake()->randomElement($recommend)),
        ];
    }
}
