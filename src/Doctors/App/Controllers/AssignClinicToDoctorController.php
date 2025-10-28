<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Lightit\Doctors\App\Requests\AssignClinicRequest;
use Lightit\Doctors\Domain\Actions\AssignClinicAction;
use Lightit\Doctors\Domain\Models\Doctor;
#[Group('doctors')]
class AssignClinicToDoctorController
{
    public function __invoke(Doctor $doctor, AssignClinicRequest $request, AssignClinicAction $assignClinicAction,): Response
    {
        $assignClinicAction->execute($doctor, $request->integer(AssignClinicRequest::CLINIC_ID));

        return response()->noContent();
    }
}
