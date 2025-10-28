<?php

declare(strict_types=1);

namespace Tests\Feature\Doctors;

use Database\Factories\DoctorFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Doctors\App\Controllers\GetDoctorController;
use Lightit\Doctors\App\Resources\DoctorResource;
use function Pest\Laravel\getJson;

describe('doctors', function (): void {
    /** @see GetDoctorController */

    it('retrieves a doctor and returns a successful response', function (): void {
        $existingDoctor = DoctorFactory::new()->createOne();

        getJson("api/doctors/$existingDoctor->id")
            ->assertOk()
            ->assertJson(
                DoctorResource::make($existingDoctor)->response()->getData(true)
            );
    });

    it('returns a 404 response when doctor is not found', closure: function (): void {
        $nonExistentDoctorId = 99999;

        getJson("api/doctors/{$nonExistentDoctorId}")->assertNotFound();
    });
});
