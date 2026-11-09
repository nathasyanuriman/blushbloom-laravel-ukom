<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name' => 'Admin', 
                'password' => Hash::make('admin123'), 
                'role' => 'admin', 
                'phone' => '0895325967112'
            ]
        );

        User::firstOrCreate(
            ['email' => 'Nathasya@gmail.com'], 
            [
                'name' => 'Nathasya', 
                'password' => Hash::make('12345678'), 
                'role' => 'customer', 
                'phone' => '08818280643'
            ]
        );

        $services = [
            [
                'name' => 'Makeup Pengantin', 
                'description' => 'Tampilan anggun untuk hari pernikahan, lengkap dengan konsultasi look.', 
                'price' => 1500000,
                'is_active' => true
            ],
            [
                'name' => 'Makeup Wisuda', 
                'description' => 'Riasan fresh dan tahan lama untuk momen kelulusan.', 
                'price' => 350000,
                'is_active' => true
            ],
            [
                'name' => 'Makeup Prewedding', 
                'description' => 'Look fotogenik untuk sesi foto prewedding dan momen spesial.', 
                'price' => 750000,
                'is_active' => true
            ],
            [
                'name' => 'Makeup Party', 
                'description' => 'Riasan glam untuk pesta, ulang tahun, dan acara malam.', 
                'price' => 450000,
                'is_active' => true
            ],
            [
                'name' => 'Makeup Natural', 
                'description' => 'Tampilan ringan dan natural untuk acara santai.', 
                'price' => 300000,
                'is_active' => true
            ],
            [
                'name' => 'Makeup Lamaran', 
                'description' => 'Riasan manis dan elegan untuk acara lamaran.', 
                'price' => 900000,
                'is_active' => true
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']], 
                $service
            );
        }
    }
}