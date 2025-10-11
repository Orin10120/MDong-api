<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <= 2; $i++) {
            Project::create([
                'student_id'     => $i,
                'project_type'   => $i % 2 == 0 ? 'Perancangan' : 'analisa',
                'project_name'   => 'Project ' . $i,
                'visual_path'    => 'projects/visual' . $i . '.jpg',
                'technique'      => 'Technique ' . $i,
                'method'         => 'Method ' . $i,
                'material'      => 'Material ' . $i,
                'narration'     => 'This is the narration for project ' . $i,
            ]);
        }
    }
}
