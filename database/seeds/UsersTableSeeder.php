<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sentinel::registerAndActivate([
            'email' => 'maxi.rebolledo@gmail.com',
            'first_name' => 'Maximiliano',
            'last_name' => 'Rebolledo',
            'password' => 'ws102030'
        ]);
    }
}
