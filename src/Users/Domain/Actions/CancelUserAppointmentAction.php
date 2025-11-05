<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;

class CancelUserAppointmentAction
{
    public function execute(Appointment $appointment): Appointment
    {
        $appointment->status = AppointmentStatus::Cancelled;

        $appointment->saveOrFail();

        return $appointment;
    }
}
