<?php

namespace App\Models;

use App\Models\TinhThanh;
use App\Models\HinhAnh;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaDanh extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenDiaDanh',
        'moTa',
        'kinhDo',
        'viDo',
        'tinh_thanh_id',
        'trangThai',
    ];

    public function tinhthanh()
    {
        return $this->belongsTo(TinhThanh::class, 'tinh_thanh_id');
    }

    public function hinhanh()
    {
        return $this->belongsTo(HinhAnh::class, 'id');
    }

    public function hinhanhs()
    {
        return $this->hasMany(HinhAnh::class, 'id');
    }
}
