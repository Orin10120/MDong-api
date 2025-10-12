<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            Student::create([
                'name'             => 'Student ' . $i,
                'student_number'   => 2023000 + $i,
                'username'         => 'student' . $i,
                'email'            => 'student' . $i . '@student.edu',
                'password'         => bcrypt('password#123'),
                'phone_number'     => '08123456789' . $i,
                'major'            => 'Information Technology',
                'class'            => 'IT-1A',
                'entry_year'       => 2023,
                'social_media_url' => 'https://twitter.com/student' . $i,
                'status'           => 'DRAFT',
            ]);
        }
    }
}
