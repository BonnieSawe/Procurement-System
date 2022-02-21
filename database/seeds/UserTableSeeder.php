<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([  
            'first_name' => 'Shiqs Meee', 
            'phone_number1' => '+254721234567',
            'role_id' => '1',           
            'email' => 'shiqs6@gmail.com', 
            'password' => bcrypt('shiks2018'),
        ]);
    }
}
