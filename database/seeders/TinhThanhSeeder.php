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
            ['tenTinhThanh' => 'Hồ Chí Minh'],
            ['tenTinhThanh' => 'Hà Nội'],
            ['tenTinhThanh' => 'Đà Nẵng'],
            ['tenTinhThanh' => 'Kiên Giang'],
            ['tenTinhThanh' => 'Quảng Ninh'],
            ['tenTinhThanh' => 'Long An'],
            ['tenTinhThanh' => 'Cao Bằng'],
            ['tenTinhThanh' => 'Hải Phòng'],
            ['tenTinhThanh' => 'Quảng Bình'],
            ['tenTinhThanh' => 'Cao Bằng'],
        ]);
    }
}
