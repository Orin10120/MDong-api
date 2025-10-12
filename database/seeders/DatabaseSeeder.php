<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Console\Application;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StudentSeeder::class,
            LectureSeeder::class,
            ApplicationHistoriesSeeder::class,
            HistoryLectureSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
