<?php

declare(strict_types=1);

namespace Tests\Feature\Doctors;

use Database\Factories\DoctorFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Models\Doctor;
use Tests\RequestFactories\StoreDoctorRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('doctors', function (): void {
    /** @see UpdateDoctorController */
    it(description: 'can create a doctor successfully', closure: function (): void {
        $data = StoreDoctorRequestFactory::new()->create();

        $response = postJson(url('/api/doctors'), $data);

        $doctor = Doctor::query()
            ->where('name', $data['name'])
            ->firstOrFail();
        $response
            ->assertCreated()
            ->assertJson(
                fn (AssertableJson $json): AssertableJson => $json->has(
                    'data',
                    fn (AssertableJson $json): AssertableJson => $json->whereAll(
                        DoctorResource::make($doctor)->resolve()
                    )
                )
            );

        assertDatabaseHas('doctors', [
            'name' => $data['name'],
        ]);
    });

    it('can edit a doctor with the same name', function (): void {
        $existingDoctor = DoctorFactory::new()->createOne();

        $data = StoreDoctorRequestFactory::new()->create([
            'name' => $existingDoctor->name,
        ]);

        $response = putJson(url("/api/doctors/$existingDoctor->id"), $data);

        $response->assertOk();

        assertDatabaseHas('doctors', [
            'name' => $data['name'],
        ]);
    });
});
