<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = UserFactory::new()->createMany(35);
        $clinics = ClinicFactory::new()->createMany(35);
        $doctors = DoctorFactory::new()->createMany(35)
            ->each(function ($doctor) use ($clinics) {
                $doctor->clinics()->attach($clinics->random(),
                    ['created_at' => now(), 'updated_at' => now()]);
            });
        AppointmentFactory::new()->recycle($doctors, $users, $clinics)->createMany(30);
    }
}
