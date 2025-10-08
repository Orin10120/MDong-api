<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application_History extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'status',
        'is_pembimbing',
        'tanggal_submit',
        'tanggal_response',
    ];
}
