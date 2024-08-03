<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course=Course::create([
            'name' => 'متتاليا',
            'price' => '1000',
            'description' => 'hi this is my #m_tag',
            'photo'=>'/storage/Course_photos/math.jpg',
            'user_id'=>'1',
            'subject_id'=>'1',
            'approved'=>'1'
        ]);


        preg_match_all('/#(\w+)/', $course->description, $matches);
            $tags = collect($matches[1]);

            $tags->each(function ($tagName) use ($course) {
                $tagModel = Tag::firstOrCreate(['name' => $tagName]);
                $course->tags()->attach($tagModel);
            });

    }
}
