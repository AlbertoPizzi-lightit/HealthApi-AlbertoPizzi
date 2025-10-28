<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

class AssignClinicAction
{
    public function execute(Doctor $doctor, int $clinicId): void
    {
        $doctor->clinics()->attach($clinicId);
    }
}
