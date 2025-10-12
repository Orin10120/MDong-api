<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoryLectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $historyIds = DB::table('application_histories')->pluck('id');
        $lectureIds = DB::table('lecturers')->pluck('id');


        if ($historyIds->isEmpty() || $lectureIds->isEmpty()) {
            echo "Pastikan ApplicationHistorySeeder dan LecturerSeeder sudah dijalankan.\n";
            return;
        }

        $pivotData = [];
        $count = 4;

        for ($i = 0; $i < $count; $i++) {
            $pivotData[] = [
                'history_id' => $historyIds->random(),
                'lecture_id' => $lectureIds->random(),
            ];
        }

        DB::table('history_user')->insert($pivotData);
    }
}
