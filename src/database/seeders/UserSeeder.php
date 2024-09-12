<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create("Admin", "admin@cnc.community", "admin");
        $this->create("Editor", "editor@cnc.community", "editor");
    }

    private function create($name, $email, $role)
    {
        $category = new User();
        $category->name = $name;
        $category->email = $email;
        $category->role = $role;
        $category->password = bcrypt("password");
        $category->save();
    }
}
