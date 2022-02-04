<?php

namespace App\Models;

use App\Models\DiaDanh;
use App\Models\NhuCau;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaDanhNhuCau extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'idDiaDanh',
        'idNhuCau',
    ];

    public function diadanh()
    {
        return $this->belongsTo(DiaDanh::class, 'idDiaDanh');
    }

    public function nhucau()
    {
        return $this->belongsTo(NhuCau::class, 'idNhuCau');
    }
}
