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
        DB::table('account')->insert([
            ['uuid' => 'UUID', 'email' => 'marcelo@mail.com', 'password' => '$2y$10$zBRbjr60m6L7xj.7IYUAQe6bKo90jLo8EJ0.oG2jRVTM11tp4.TGK', 'is_admin' => 1, 'created_at' => gmdate('Y-m-d H:i:s')],
        ]);
    }
}
