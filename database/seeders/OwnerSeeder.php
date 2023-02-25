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
        ]);
    }
}
