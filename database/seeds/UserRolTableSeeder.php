<?php

use Illuminate\Database\Seeder;

class UserRolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = gmdate('Y-m-d H:i:s');

        DB::table('user_rol')->insert([
            ['rol_id' => 1, 'user_id' => 1, 'created_at'  => $createdAt],
        ]);
    }
}
