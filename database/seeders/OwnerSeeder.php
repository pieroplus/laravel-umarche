<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('owners')->insert([
            [
                'name' => 'owner',
                'email' => 'owner@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner2',
                'email' => 'owner2@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner3',
                'email' => 'owner3@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner4',
                'email' => 'owner4@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner5',
                'email' => 'owner5@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner6',
                'email' => 'owner6@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner7',
                'email' => 'owner7@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner8',
                'email' => 'owner8@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner9',
                'email' => 'owner9@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
            [
                'name' => 'owner10',
                'email' => 'owner10@hoge.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/01/01 11:11:11'
            ],
        ]);
    }
}
