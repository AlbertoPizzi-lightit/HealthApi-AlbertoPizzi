<?php

declare(strict_types=1);

namespace Lightit\Users\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Actions\CancelUserAppointmentAction;

#[Group('Users')]
final readonly class CancelMyAppointmentController
{
    public function __invoke(
        Appointment $appointment,
        CancelUserAppointmentAction $action,
    ): JsonResponse {
        $action->execute($appointment);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
