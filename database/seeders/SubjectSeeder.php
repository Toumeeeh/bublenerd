<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SubjectSeeder extends Seeder
{

//    public function run(): void
//    {
//
//        $subjects = [
//            'الرياضيات',
//            'الفيزياء',
//            'الكيمياء',
//            'علم الاحياء',
//            'اللغة العربية',
//            'اللغة الإنكليزية',
//            'اللغة الفرنسية',
//            'اللغة الروسية',
//            'التربية الوطنية',
//            'الديانة الإسلامية',
//            'الفلسفة',
//            'الجغرافية',
//            'التاريخ',
//        ];
//
//        foreach ($subjects as $subject)
//        {
//            Subject::create([
//                'name' => $subject,
//            ]);
//        }
//
//    }

    public function run()
    {
        $subjects = [
            'الرياضيات' => 'math.jpg',
            'الفيزياء' => 'physics.jpg',
            'الكيمياء' => 'chemistry.jpg',
            'علم الاحياء'=>'science.jpg',
            'اللغة العربية'=>'arabic.jpg',
            'اللغة الإنكليزية'=>'english.jpg',
            'اللغة الفرنسية'=>'franc',
            'اللغة الروسية',
            'التربية الوطنية',
            'الديانة الإسلامية',
            'الفلسفة',
            'الجغرافية',
            'التاريخ',
        ];

        foreach ($subjects as $subject => $photo) {
            $photoPath = '/storage/subjects_photo/' . $photo;
            Storage::copy('/storage/subjects_photo/' . $photo, $photoPath);

            Subject::create([
                'name' => $subject,
                'photo' => $photoPath,
            ]);
        }
    }

}
