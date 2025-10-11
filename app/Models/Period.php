<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['lecturer_id', 'start_date', 'end_date'];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
