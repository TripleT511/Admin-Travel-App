<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LuuTru extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'dia_danh_id',
        'tenLuuTru',
        'moTa',
        'diaChi',
        'sdt',
        'thoiGianHoatDong',
        'hinhAnh',
    ];

    public function diadanh()
    {
        return $this->belongsTo(DiaDanh::class, 'dia_danh_id');
    }
}
