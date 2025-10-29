<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Requests\AssignClinicRequest;
use Lightit\Doctors\Domain\Actions\AssignClinicAction;
use Lightit\Doctors\Domain\Models\Doctor;

#[Group('doctors')]
final class AssignClinicToDoctorController
{
    public function __invoke(
        Doctor $doctor,
        AssignClinicRequest $request,
        AssignClinicAction $assignClinicAction,
    ): JsonResponse {
        $assignClinicAction->execute($doctor, $request->getClinicId());

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
