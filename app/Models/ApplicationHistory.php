<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    protected $fillable = [
    'student_id',
    'status',
    'is_pembimbing',
    'submission_date',
    'response_date',
];

    // inverse one to many relationship with student
    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function getApiResponseAttribute() {
        return [
        'student_id'      => $this->student_id,
        'status'          => $this->status,
        'is_pembimbing' => $this->is_pembimbing,
        'submission_date' => $this->submission_date,
        'response_date'   => $this->response_date,
        ];
    }
}
