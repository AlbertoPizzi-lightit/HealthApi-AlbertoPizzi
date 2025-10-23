<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Appointments\Domain\Models\Appointment;

/**
 * @extends Factory<\Lightit\Appointments\Domain\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    public function definition(): array
    {
        return [
            'doctor_id' => DoctorFactory::new(),
            'user_id' => UserFactory::new(),
            'clinic_id' => ClinicFactory::new(),
            'start_time' => fake()->dateTimeBetween('+1 week', '+3 weeks'),
            'end_time' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['start_time'], '+1 hour');
            }];
    }
}
