<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens;

    protected $fillable = [
    'name',
    'student_number',
    'username',
    'email',
    'password',
    'phone_number',
    'major',
    'class',
    'entry_year',
    'social_media_url',
    'status',
    ];

    // one to one relationship with Project
    public function project() {
        return $this->hasOne(Project::class);
    }

    // one to many relationship with Application_History
    public function applicationHistories() {
        return $this->hasMany(ApplicationHistory::class);
    }

    public function getApiResponseAttribute() {
        return [
        'name'             => $this->name,
        'student_number'   => $this->student_number,
        'email'            => $this->email,
        'phone_number'     => $this->phone_number,
        'major'            => $this->major,
        'class'            => $this->class,
        'entry_year'       => $this->entry_year,
        'social_media_url' => $this->social_media_url,
        'status'           => $this->status,
        ];
    }
}
