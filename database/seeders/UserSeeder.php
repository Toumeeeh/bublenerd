<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'user_type' => 'teacher',
            'name' => 'toumeh',
            'email' => 'wajeehxxt@gmail.com',
            'email_verified_at'=>'2024-05-08 15:35:53',
            'phone'=>'0943946262',
            'bio'=>'hello',
            'avatar'=>'storage/user-avatars/avatar.png',
            'password'=> Hash::make('password'),
            'device_token'=>'d0lKNrtzSMqCqp1ypHoovS:APA91bGcsanKu2xoSKcTAfTDTeaJcLkM6dV-8-iZQbCe4W-ux73LXtnG5ulu-Koh7FzHubzHed7vslxixxN1OX-3ZtDvbulzecdzgPzyETCKk_xGAkaElH56trjl4fTX1LwCENYldZtG',
            'wallet'=>'1000000'
        ]);

        $user->subjects()->attach(1);

        $user = User::create([
            'user_type' => 'teacher',
            'name' => 'teacher',
            'email' => 'teacher@gmail.com',
            'email_verified_at'=>'2024-05-08 15:35:53',
            'phone'=>'0943946222',
            'bio'=>'hello',
            'avatar'=>'storage/user-avatars/avatar.png',
            'password'=> Hash::make('password'),
            'device_token'=>'fake_token_'
        ]);

        $user->subjects()->attach(1);

        $user = User::create([
            'user_type' => 'student',
            'name' => 'saria',
            'email' => 'student@gmail.com',
            'email_verified_at'=>'2024-05-08 15:35:53',
            'phone'=>'0943333222',
            'bio'=>'hello',
            'avatar'=>'storage/user-avatars/avatar.png',
            'password'=> Hash::make('password'),
            'device_token'=>'fake_token_'
        ]);

        $user = User::create([
            'user_type' => 'Admin',
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'email_verified_at'=>'2024-05-08 15:35:53',
            'phone'=>'0943946265',
            'bio'=>'hello',
            'avatar'=>'/storage/user-avatars/avatar.png',
            'password'=> Hash::make('password'),
            'device_token'=>'fake_token_'
        ]);
        $user = User::create([
            'user_type' => 'teacher',
            'name' => 'nana',
            'email' => 'nana@gmail.com',
            'email_verified_at'=>'2024-05-08 15:35:53',
            'phone'=>'0943946221',
            'bio'=>'hello',
            'avatar'=>'storage/user-avatars/avatar.png',
            'password'=> Hash::make('password'),
            'device_token'=>'fake_token_'
        ]);

        $user->subjects()->attach(1);

    }
}
