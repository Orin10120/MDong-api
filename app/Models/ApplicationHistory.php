<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    protected $fillable = [
        'student_id',
        'is_pembimbing',
        'submission_date',
        'response_date',
        'response',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'response_date' => 'date',
    ];

    // inverse one to many relationship with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getApiResponseAttribute()
    {
        return [
            'student_id'      => $this->student_id,
            'is_pembimbing' => $this->is_pembimbing,
            'submission_date' => $this->submission_date->format('d-m-Y'),
            'response_date'   => $this->response_date ? $this->response_date->format('d-m-Y') : null,
            'response'        => $this->response,
        ];
    }
}
