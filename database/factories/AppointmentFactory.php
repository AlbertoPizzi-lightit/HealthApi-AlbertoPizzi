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
            'doctor' => fake()->name(),
            'patient' => fake()->name(),
            'clinic' => fake()->name(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
        ];
    }
}
