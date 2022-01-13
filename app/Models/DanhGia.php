<?php

namespace App\Models;

use App\Models\BaiVietChiaSe;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhGia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'idBaiViet',
        'idUser',
        'userLike',
        'userUnLike',
        'userXem',
    ];

    public function baiviet()
    {
        return $this->belongsTo(BaiVietChiaSe::class, 'idBaiViet');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idBaiViet');
    }
}
