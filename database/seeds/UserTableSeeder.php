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
            'first_name' => 'Shiqs Muthoni', 
            'phone_number1' => '+254722425829',
            'role_id' => '1',           
            'email' => 'shiqs@gmail.com', 
            'password' => bcrypt('shiks2018'),
        ]);
    }
}
