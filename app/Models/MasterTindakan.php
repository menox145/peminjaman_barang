<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTindakan extends Model
{
    use HasFactory;

    protected $table = 'master_tindakan';

    protected $fillable = [
        'kode_tindakan',
        'nama_tindakan',
        'harga',
        'keterangan',
        'jenis_tindakan',
        'group_tindakan'
    ];
} 