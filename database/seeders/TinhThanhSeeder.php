<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        for ($i = 0; $i < 5; $i++) {
            $tinh = new TinhThanh();
            $tinh->fill([
                'tenTinhThanh' => 'Tỉnh thành ' . $i,
                'trangThai' => 1,
            ]);
            $tinh->save();
        }
    }
}
