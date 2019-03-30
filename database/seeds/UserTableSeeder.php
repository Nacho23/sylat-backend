<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            ['uuid' => 'UUID', 'account_id' => 1, 'first_name' => 'Marcelo', 'last_name' => 'Torres', 'email' => 'marcelo@mail.com', 'rut' => '18653129', 'rut_dv' => '9', 'unit_id' => '1', 'phone_mobile' => '965002727', 'created_at' => gmdate('Y-m-d H:i:s')],
        ]);
    }
}
