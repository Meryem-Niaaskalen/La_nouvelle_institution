<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'school_name', 'value' => 'La nouvelle institution', 'type' => 'string', 'description' => 'Nom de l\'établissement'],
            ['key' => 'school_motto', 'value' => 'Depuis 1997', 'type' => 'string', 'description' => 'Devise de l\'établissement'],
            ['key' => 'school_address', 'value' => 'Hay El Fath 3, rue 20, villa 25/27, Ain Chok, Casablanca - Maroc', 'type' => 'string', 'description' => 'Adresse de l\'établissement'],
            ['key' => 'school_phone', 'value' => '+212 5 22 87 56 34', 'type' => 'string', 'description' => 'Numéro de téléphone principal'],
            ['key' => 'school_phone_secondary', 'value' => '', 'type' => 'string', 'description' => 'Numéro de téléphone secondaire'],
            ['key' => 'school_phone_tertiary', 'value' => '', 'type' => 'string', 'description' => 'Numéro de téléphone supplémentaire'],
            ['key' => 'school_email', 'value' => 'gsni2527@gmail.com', 'type' => 'string', 'description' => 'Email de l\'établissement'],
            ['key' => 'school_facebook', 'value' => 'https://web.facebook.com/profile.php?id=100056328531139', 'type' => 'string', 'description' => 'Page Facebook'],
            ['key' => 'school_coordinates_lat', 'value' => '33.5731', 'type' => 'string', 'description' => 'Latitude Google Maps'],
            ['key' => 'school_coordinates_lng', 'value' => '-7.5898', 'type' => 'string', 'description' => 'Longitude Google Maps'],
            ['key' => 'total_students', 'value' => '850', 'type' => 'string', 'description' => 'Nombre total d\'élèves'],
            ['key' => 'total_teachers', 'value' => '45', 'type' => 'string', 'description' => 'Nombre total d\'enseignants'],
            ['key' => 'total_graduates', 'value' => '3200', 'type' => 'string', 'description' => 'Nombre total de diplômés'],
            ['key' => 'years_of_operation', 'value' => '27', 'type' => 'string', 'description' => 'Années de fonctionnement'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
