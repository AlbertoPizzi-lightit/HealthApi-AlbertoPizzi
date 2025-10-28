<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

class AssignDoctorAction
{
    public function execute(Clinic $clinic, int $doctorId):void
    {
        $clinic->doctors()->attach($doctorId);
    }
}
