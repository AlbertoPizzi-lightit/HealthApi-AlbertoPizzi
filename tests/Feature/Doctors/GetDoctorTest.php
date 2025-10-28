<?php

declare(strict_types=1);

namespace Tests\Feature\Doctors;

use Database\Factories\DoctorFactory;
use Lightit\Doctors\App\Controllers\GetDoctorController;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Models\Doctor;
use function Pest\Laravel\getJson;

describe('doctors', function (): void {
    /** @see GetDoctorController */

    it('retrieves a doctor and returns a successful response', function (): void {
        /** @var Doctor $existingDoctor */
        $existingDoctor = DoctorFactory::new()->createOne();
        /** @var array $data */
        $data = DoctorResource::make($existingDoctor)->response()->getData(true);
        getJson("api/doctors/$existingDoctor->id")
            ->assertOk()
            ->assertJson($data);
    });

    it('returns a 404 response when doctor is not found', closure: function (): void {
        $nonExistentDoctorId = 99999;

        getJson("api/doctors/{$nonExistentDoctorId}")->assertNotFound();
    });
});
