<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'customer_name',
        'no_hp',
        'brand',
        'model',
        'keluhan',
        'analisa_teknisi',
        'biaya',
        'status',
        'tanggal_masuk',
        'tanggal_selesai'
    ];
}
