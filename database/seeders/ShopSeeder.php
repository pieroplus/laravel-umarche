<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample1.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 2,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample2.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 3,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample3.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 4,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample4.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 5,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample5.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 6,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample1.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 7,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample2.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 8,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample3.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 9,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample4.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 10,
                'name' => 'ここに店名が入ります。',
                'information' => 'ここにお店の情報が入ります。ここにお店の情報が入ります。ここにお店の情報が入ります。',
                'filename' => 'sample5.jpg',
                'is_selling' => true,
            ],
        ]);

    }
}
