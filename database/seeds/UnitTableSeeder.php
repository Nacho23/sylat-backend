<?php

use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit')->insert([
            ['id' => 0, 'uuid' => 'UUID', 'name' => 'Unidad 0', 'code' => 0, 'created_at' => gmdate('Y-m-d H:i:s')],
        ]);
    }
}
