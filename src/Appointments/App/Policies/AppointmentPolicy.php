<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Policies;

use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;

class AppointmentPolicy
{
    public function cancel(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }
}
