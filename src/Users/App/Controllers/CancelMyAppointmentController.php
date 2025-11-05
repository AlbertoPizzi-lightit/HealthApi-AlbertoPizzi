<?php

declare(strict_types=1);

namespace Lightit\Users\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Actions\CancelUserAppointmentAction;
use Lightit\Users\Domain\Models\User;

#[Group('Users')]
final readonly class CancelMyAppointmentController
{
    public function __invoke(
        #[CurrentUser]
        User $user,
        Appointment $appointment,
        CancelUserAppointmentAction $action,
    ): JsonResponse {
        $appointment = $user->appointments->find($appointment->id);
        /** @var Appointment $appointment */
        $action->execute($appointment);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
