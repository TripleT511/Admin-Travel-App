<?php

namespace App\Models;

use App\Models\HinhAnh;
use App\Models\DiaDanh;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaiVietChiaSe extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'idDiaDanh',
        'idUser',
        'noiDung',
        'thoiGian',
        'trangThai',
    ];

    public function diadanh()
    {
        return $this->belongsTo(DiaDanh::class, 'idDiaDanh');
    }

    public function hinhanh()
    {
        return $this->belongsTo(HinhAnh::class, 'id', 'idBaiVietChiaSe');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}