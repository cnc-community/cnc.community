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
        $this->create("Official News");
        $this->create("Community News");
    }

    private function create($name)
    {
        $category = new Category();
        $category->name = $name;
        $category->save();
    }
}
