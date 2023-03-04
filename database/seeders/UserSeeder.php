<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'user',
                'email' => 'user@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user2',
                'email' => 'user2@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user3',
                'email' => 'user3@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user4',
                'email' => 'user4@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user5',
                'email' => 'user5@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user6',
                'email' => 'user6@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user7',
                'email' => 'user7@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user8',
                'email' => 'user8@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user9',
                'email' => 'user9@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'user10',
                'email' => 'user10@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
        ]);
    }
}
