<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@sumaterainterior.test'],
            [
                'name' => 'Admin Sumatera Interior',
                'password' => Hash::make('password'),
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@sumaterainterior.test'],
            [
                'name' => 'User Sumatera Interior',
                'password' => Hash::make('password'),
            ]
        );

        $admin->syncRoles([$adminRole]);
        $user->syncRoles([$userRole]);

        About::firstOrCreate(
            ['title' => 'Tentang Sumatera Interior'],
            [
                'headline' => 'Interior personal, rapi, dan elegan untuk rumah maupun bisnis.',
                'content' => 'Kami menghadirkan layanan desain dan instalasi interior dengan fokus pada detail, kualitas material, dan kenyamanan pengguna.',
                'vision' => 'Menjadi partner interior terpercaya di Indonesia.',
                'mission' => 'Memberikan solusi interior fungsional, estetis, dan tahan lama.',
            ]
        );

        Contact::firstOrCreate(
            ['title' => 'Hubungi Kami'],
            [
                'address' => 'Jl. Interior No. 123, Medan, Sumatera Utara',
                'phone' => '+62 812 3456 7890',
                'email' => 'hello@sumaterainterior.test',
                'whatsapp' => '+62 812 3456 7890',
                'instagram' => '@sumaterainterior',
                'business_hours' => 'Senin - Sabtu, 09:00 - 17:00',
            ]
        );
    }
}
