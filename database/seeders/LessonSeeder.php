<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            'name'=>'first video',
            'video'=>'/storage/lesson_videos/mixkit-animation-of-futuristic-devices-99786.mp4',
            'course_id'=>'1'
        ]);
    }
}
