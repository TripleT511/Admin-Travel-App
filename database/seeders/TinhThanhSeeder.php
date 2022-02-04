<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TinhThanh;

class TinhThanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tinh_thanhs')->insert([
            ['tenTinhThanh' => 'TP Hồ Chí Minh'],
            ['tenTinhThanh' => 'Hà Nội'],
            ['tenTinhThanh' => 'Đà Nẵng'],
            ['tenTinhThanh' => 'Kiên Giang'],
            ['tenTinhThanh' => 'Quảng Ninh'],
            ['tenTinhThanh' => 'Long An'],
            ['tenTinhThanh' => 'Cao Bằng'],
            ['tenTinhThanh' => 'Hải Phòng'],
            ['tenTinhThanh' => 'Quảng Bình'],
            ['tenTinhThanh' => 'Ohara'],
            ['tenTinhThanh' => 'Water Seven'],
            ['tenTinhThanh' => 'Wano'],
            ['tenTinhThanh' => 'Goat'],
            ['tenTinhThanh' => 'Shimotsuki'],
            ['tenTinhThanh' => 'Thriller Bark'],
            ['tenTinhThanh' => 'Germa'],
            ['tenTinhThanh' => 'Yoshuba'],
            ['tenTinhThanh' => 'Red Line'],
            ['tenTinhThanh' => 'Onigashima'],
            ['tenTinhThanh' => 'Alabasta'],
            ['tenTinhThanh' => 'Udon'],
            ['tenTinhThanh' => 'Ringo'],
            ['tenTinhThanh' => 'Elbaf'],
            ['tenTinhThanh' => 'Laugh Tale'],
            ['tenTinhThanh' => 'Impel Down'],
            ['tenTinhThanh' => 'Skypiea'],
            ['tenTinhThanh' => 'Wheatheria'],
            ['tenTinhThanh' => 'All Blue'],
            ['tenTinhThanh' => 'God Valley'],

        ]);
    }
}
