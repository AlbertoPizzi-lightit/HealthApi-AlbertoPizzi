<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Doctors\Domain\Models\Doctor;

/**
 * @extends Factory<\Lightit\Doctors\Domain\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'clinics' => fake()->name(),
        ];
    }
}
