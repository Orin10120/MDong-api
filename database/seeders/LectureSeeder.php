<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <= 4 ; $i++) {
            Lecturer::create([
                'name' => 'Dosen ' . $i,
                'code' => 'DSN' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nip' => '123456789' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'username' => 'dosen' . $i,
                'email' => 'dosen' . $i . '@example.com',
                'password' => bcrypt('password'),
                'phone' => '08123456789' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'is_admin' => 'NO',
                'study_program' => 'Teknik Informatika',
            ]);
        }
    }
}
