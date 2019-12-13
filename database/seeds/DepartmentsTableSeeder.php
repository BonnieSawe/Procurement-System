<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deps = array("Human Resource", "Kitchen", "Procurement", "Adminstration");

        foreach($deps as $dep)
        {
            Department::create([
                'name' => $dep,
            ]);
        }
    }
}
