<?php

namespace App\Models;

use App\Models\DiaDanh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhuCau extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenNhuCau',
        'trangThai',
    ];

    public function diadanhs()
    {
        return $this->hasMany(DiaDanh::class, 'id');
    }
}
