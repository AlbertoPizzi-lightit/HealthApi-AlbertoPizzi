<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\AssignDoctorRequest;
use Lightit\Clinics\Domain\Actions\AssignDoctorAction;
use Lightit\Clinics\Domain\Models\Clinic;

#[Group('Clinics')]
final class AssignDoctorToClinicController
{
    public function __invoke(
        Clinic $clinic,
        AssignDoctorRequest $request,
        AssignDoctorAction $assignDoctorAction,
    ): JsonResponse {
        $assignDoctorAction->execute($clinic, $request->getDoctorId());

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
