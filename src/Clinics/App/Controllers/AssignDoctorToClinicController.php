<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Lightit\Clinics\App\Requests\AssignDoctorRequest;
use Lightit\Clinics\Domain\Actions\AssignDoctorAction;
use Lightit\Clinics\Domain\Models\Clinic;

#[Group('Clinics')]
final readonly class AssignDoctorToClinicController
{
    public function __invoke(
        Clinic $clinic,
        AssignDoctorRequest $request,
        AssignDoctorAction $assignDoctorAction,
    ): Response {
        $assignDoctorAction->execute($clinic, $request->integer(AssignDoctorRequest::DOCTOR_ID));

        return response()->noContent();
    }
}
