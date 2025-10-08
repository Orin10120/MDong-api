<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nama',
        'nim',
        'email',
        'password',
        'no_tlp',
        'program_studi',
        'kelas',
        'angkatan',
        'url_sosmed',
        'status',
    ];
}
