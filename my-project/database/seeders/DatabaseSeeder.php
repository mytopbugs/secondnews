<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        News::truncate();
        News::factory(101)->create();
    }
}
