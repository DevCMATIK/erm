<?php

use App\Domain\Data\Analogous\AnalogousReport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
	        //RolesTableSeeder::class,
            //PermissionsTableSeeder::class,
            //UsersTableSeeder::class,
            // UserRolesTableSeeder::class,
            MenuRolesTableSeeder::class
        ]);
    }
}
