<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $this->create("Community News", "community-news");
    }

    private function create($name, $slug)
    {
        $category = new Category();
        $category->name = $name;
        $category->slug = $slug;
        $category->save();
    }
}
