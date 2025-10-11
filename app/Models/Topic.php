<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecturer_id', 'topic_name', 'description', 'requirement',
        'limit_supervise', 'limit_applied'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
