<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiaDanh;

class DiaDanhSeeder extends Seeder
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
            $diaDanh = new DiaDanh();
            $diaDanh->fill([
                'tenDiaDanh' => 'Địa danh ' . $i,
                'moTa' => "ABC",
                'kinhDo' => "1000",
                'viDo' => "10000",
                'tinh_thanh_id' => 2,
                'trangThai' => 1,
            ]);
            $diaDanh->save();
        }
    }
}
