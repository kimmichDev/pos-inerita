<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("swsxswsx")
        ]);

        $categories = ["Coffe based", "Tea based", "Kitchen's made"];
        foreach ($categories as $c) {
            Category::create([
                "name" => $c,
            ]);
        }

        Item::factory()->count(25)->create();
    }
}
