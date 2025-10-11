<?php

namespace Database\Seeders;

use App\Models\ApplicationHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationHistoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <= 2; $i++) {
            ApplicationHistory::create([
                'student_id' => $i,
                'is_pembimbing' => 'PBB-1',
                'submission_date' => now(),
                'response_date' => now(),
                'response' => 'PENDING',
            ]);
        }
    }
}
