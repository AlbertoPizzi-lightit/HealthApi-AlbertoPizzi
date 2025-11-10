<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\App\Notifications\UserAppointmentCancelledNotification;

class CancelUserAppointmentAction
{
    use AuthorizesRequests;

    /**
     * @throws \Throwable
     * @throws AuthorizationException
     */
    public function execute(Appointment $appointment): Appointment
    {
        $this->authorize('cancel', $appointment);
        $appointment->status = AppointmentStatus::Cancelled;

        $appointment->saveOrFail();

        $appointment->user->notify(new UserAppointmentCancelledNotification());



        return $appointment;
    }
}
