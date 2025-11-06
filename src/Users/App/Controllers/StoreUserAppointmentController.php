<?php

declare(strict_types=1);

namespace Lightit\Users\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Users\App\Requests\UpsertUserAppointmentRequest;
use Lightit\Users\Domain\Actions\StoreUserAppointmentAction;

#[Group('Users')]

final readonly class StoreUserAppointmentController
{
    public function __invoke(
        UpsertUserAppointmentRequest $request,
        StoreUserAppointmentAction $storeUserAppointmentAction,
    ): JsonResponse {
        $appointmentDto = $storeUserAppointmentAction->execute($request->toDto());

        return AppointmentResource::make($appointmentDto)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
