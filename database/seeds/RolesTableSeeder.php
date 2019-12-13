<?php
use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = array("Head of Procurement", "Procurement officer", "Supplier");

        foreach($designations as $designation)
        {
            Role::create([
                'name' => $designation,
            ]);
        }
    }
}
