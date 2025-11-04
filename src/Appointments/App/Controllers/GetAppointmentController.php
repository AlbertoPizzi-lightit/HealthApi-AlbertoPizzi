<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Models\Appointment;

#[Group('Appointments')]
class GetAppointmentController
{
    public function __invoke(Appointment $appointment): JsonResponse
    {
        return AppointmentResource::make($appointment)
            ->response();
    }
}
