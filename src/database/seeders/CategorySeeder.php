<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create("Official News", "official-news");
        $this->create("Funny/Cool", "funny");
        $this->create("Other", "other");
    }

    private function create($name, $slug)
    {
        $category = new Category();
        $category->name = $name;
        $category->slug = $slug;
        $category->save();
    }
}
