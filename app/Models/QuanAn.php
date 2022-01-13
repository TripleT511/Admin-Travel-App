<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuanAn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'dia_danh_id',
        'tenQuan',
        'moTa',
        'diaChi',
        'sdt',
        'thoiGianHoatDong',
        'hinhAnh',
        'trangThai'
    ];

    public function diadanh()
    {
        return $this->belongsTo(DiaDanh::class, 'dia_danh_id');
    }

    public function monan()
    {
        return $this->belongsTo(MonAn::class, 'id', 'quan_an_id');
    }
}
