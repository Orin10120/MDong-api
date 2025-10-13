<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lecturer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'nip', 'username', 'email', 'password',
        'phone', 'is_admin', 'study_program'
    ];

    public function topic()
    {
        return $this->hasOne(Topic::class);
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }

    public function applicationHistories()
    {
        return $this->belongsToMany(ApplicationHistory::class, 'history_user', 'lecture_id', 'history_id');
    }
}
