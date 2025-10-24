<?php

declare(strict_types=1);

namespace Tests\Feature\Clinics;

use Database\Factories\ClinicFactory;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('clinics', function (): void {
    /** @see DeleteClinicController */

    it('deletes a clinic and returns a successful response', function (): void {
        $existingClinic = ClinicFactory::new()->createOne();
        $response = deleteJson("api/clinics/$existingClinic->id");
        $response->assertOk();

        assertDatabaseMissing('clinics', ['id' => $existingClinic->id]);
    });

    it('returns a 404 response when user is not found', function (): void {
        $nonExistentClinicId = 99999;

        deleteJson("api/clinics/$nonExistentClinicId")->assertNotFound();
    });
});
