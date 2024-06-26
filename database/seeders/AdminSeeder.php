<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'admin2',
                'email' => 'admin2@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'admin3',
                'email' => 'admin3@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
        ]);
    }
}
