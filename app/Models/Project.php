<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'student_id',
        'project_type',
        'project_name',
        'visual_path',
        'technique',
        'method',
        'material',
        'narration',
    ];

    // inverse one to one relationship with student
    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function getApiResponseAttribute() {
      return [
        'student_id'       => $this->student_id,
        'project_type'     => $this->project_type,
        'project_name'     => $this->project_name,
        'visual_path'      => $this->getVisualUrlAttribute(),
        'technique'        => $this->technique,
        'method'           => $this->method,
        'material'         => $this->material,
        'narration'        => $this->narration,
     ];
    }

    public function getVisualUrlAttribute() {
        if (is_null($this->visual_path)) {
            return null;
        }

        return asset('storage/' . $this->visual_path);
    }
}
