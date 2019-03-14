<?php

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = gmdate('Y-m-d H:i:s');

        DB::table('rol')->insert([
            ['name' => 'admin', 'created_at'  => $createdAt],
            ['name' => 'superadmin', 'created_at'  => $createdAt],
            ['name' => 'godson', 'created_at'  => $createdAt],
            ['name' => 'godfather', 'created_at'  => $createdAt],
        ]);
    }
}
