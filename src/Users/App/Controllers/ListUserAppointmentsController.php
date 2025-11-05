<?php

declare(strict_types=1);

namespace Lightit\Users\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Users\App\Resources\UserResource;
use Lightit\Users\Domain\Actions\ListUserAppointmentsAction;

#[Group('Users')]

class ListUserAppointmentsController
{
    public function __invoke(ListUserAppointmentsAction $action): JsonResponse
    {
        $appointments = $action->execute();

        return UserResource::collection($appointments)
            ->response();
    }
}
