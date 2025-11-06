<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;

/**
 * @extends Factory<Appointment>
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
            'start_time' => $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days'),
            'end_time' =>
                function (array $attributes)
                {
            /** @var DateTime $startTime */
                    $startTime = $attributes['start_time'];
                    return (clone $startTime)->modify('+1 hour');
                },
            'status' => AppointmentStatus::Confirmed,
        ];
    }
    public function forUser(User $user ): self
    {
        return $this->for($user, 'user');
    }
}
