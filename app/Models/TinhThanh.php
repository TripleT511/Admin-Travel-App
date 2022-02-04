<?php

namespace App\Models;

use App\Models\DiaDanh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TinhThanh extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'tenTinhThanh',
    ];

    public function diadanhs()
    {
        return $this->hasMany(DiaDanh::class, 'tinh_thanh_id');
    }
}
