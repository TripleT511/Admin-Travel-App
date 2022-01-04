<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NhuCau;

class NhuCauSeeder extends Seeder
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
            $nhucau = new NhuCau();
            $nhucau->fill([
                'tenNhuCau' => 'Nhu cầu ' . $i,
                'trangThai' => 1,
            ]);
            $nhucau->save();
        }
    }
}
