<?php

declare(strict_types=1);

namespace Lightit\Users\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Users\Domain\Models\User;

#[Group('Users')]
final readonly class GetMyAppointmentsController
{
    public function __invoke(#[CurrentUser] User $user): JsonResponse
    {
        return AppointmentResource::collection($user->appointments)
            ->response();
    }
}
