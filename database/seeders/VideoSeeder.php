<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $video= Video::create([
            'user_id' => 1,
            'name' => 'blablab',
            'description' => 'Asdas#tt',
            'subject_id'=>1,
            'video' => '/storage/lesson_videos/mixkit-animation-of-futuristic-devices-99786.mp4'
        ]);
        preg_match_all('/#(\w+)/', $video->description, $matches);
        $tags = collect($matches[1]);

        $tags->each(function ($tagName) use ($video) {
            $tagModel = Tag::firstOrCreate(['name' => $tagName]);
            $video->tags()->attach($tagModel);
        });
    }
}
