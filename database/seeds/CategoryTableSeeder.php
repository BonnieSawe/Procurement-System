<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = array("Sermons", "teachings", "inspirational", "articles");

        foreach($names as $name)
        {
            Category::create([
                'name' => $name,
                'slug' => str_slug($name),
            ]);
        }
    }
}
