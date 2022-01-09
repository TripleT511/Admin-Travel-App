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
            ['tenTinhThanh' => 'TP Hồ Chí Minh', 'trangThai' => 1],
            ['tenTinhThanh' => 'Hà Nội', 'trangThai' => 1],
            ['tenTinhThanh' => 'Đà Nẵng', 'trangThai' => 1],
            ['tenTinhThanh' => 'Logue Town', 'trangThai' => 1],
            ['tenTinhThanh' => 'Ennes Lobby', 'trangThai' => 1],
            ['tenTinhThanh' => 'Ohara', 'trangThai' => 1],
            ['tenTinhThanh' => 'Water Seven', 'trangThai' => 1],
            ['tenTinhThanh' => 'Wano', 'trangThai' => 1],
            ['tenTinhThanh' => 'Goat', 'trangThai' => 1],
            ['tenTinhThanh' => 'Shimotsuki', 'trangThai' => 1],
            ['tenTinhThanh' => 'Thriller Bark', 'trangThai' => 1],
            ['tenTinhThanh' => 'Germa', 'trangThai' => 1],
            ['tenTinhThanh' => 'Yoshuba', 'trangThai' => 1],
            ['tenTinhThanh' => 'Red Line', 'trangThai' => 1],
            ['tenTinhThanh' => 'Onigashima', 'trangThai' => 1],
            ['tenTinhThanh' => 'Alabasta', 'trangThai' => 1],
            ['tenTinhThanh' => 'Udon', 'trangThai' => 1],
            ['tenTinhThanh' => 'Ringo', 'trangThai' => 1],
            ['tenTinhThanh' => 'Elbaf', 'trangThai' => 1],
            ['tenTinhThanh' => 'Laugh Tale', 'trangThai' => 1],
            ['tenTinhThanh' => 'Impel Down', 'trangThai' => 1],
            ['tenTinhThanh' => 'Skypiea', 'trangThai' => 1],
            ['tenTinhThanh' => 'Wheatheria', 'trangThai' => 1],
            ['tenTinhThanh' => 'All Blue', 'trangThai' => 1],
            ['tenTinhThanh' => 'God Valley', 'trangThai' => 1],

        ]);
    }
}
