<?php

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
        $this->call(xAccountTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserRolTableSeeder::class);
    }
}
