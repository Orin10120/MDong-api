<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'tipe_proyek',
        'nama_proyek',
        'visual_path',
        'teknik',
        'metode',
        'material',
        'narasi',
    ];
}
