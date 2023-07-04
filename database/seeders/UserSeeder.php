<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Esteban Benitez',
            'phone' => '3105706841',
            'email' => 'estebanbenitez1996@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('Password4444.,')
        ]);
        User::create([
            'name' => 'Juanito Escarcha',
            'phone' => '3105706841',
            'email' => 'juanitoescarcha@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('Password4444.,')
        ]);
    }
}
