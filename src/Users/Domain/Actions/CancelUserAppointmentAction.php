<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;

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
        //        Gate::authorize('cancel' , $appointment);
        $appointment->status = AppointmentStatus::Cancelled;

        $appointment->saveOrFail();

        return $appointment;
    }
}
