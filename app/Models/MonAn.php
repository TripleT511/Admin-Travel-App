<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonAn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'quan_an_id',
        'tenMon',
        'hinhAnh',
        'trangThai'
    ];

    public function quanan()
    {
        return $this->belongsTo(QuanAn::class, 'quan_an_id');
    }
}
