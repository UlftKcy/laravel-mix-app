<?php

namespace Database\Seeders;

use App\Models\CategoryTypes;
use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryTypes::create([
            "name" => "Main Category",
            "code" => "main_category",
        ]);
        CategoryTypes::create([
            "name" => "Sub-One Category",
            "code" => "sub_one_category",
        ]);
        CategoryTypes::create([
            "name" => "Sub-Two Category",
            "code" => "sub_two_category",
        ]);
    }
}
