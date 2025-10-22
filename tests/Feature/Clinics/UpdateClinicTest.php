<?php
declare(strict_types=1);

namespace Tests\Feature\Clinics;

use Database\Factories\ClinicFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Clinics\App\Controllers\UpdateClinicController;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Models\Clinic;
use Tests\RequestFactories\StoreClinicRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('clinics', function () : void {
    /** @see UpdateClinicController */
        it(description: 'can create a clinic successfully', closure: function (): void {
            $data = StoreClinicRequestFactory::new()->create();

            $response = postJson(url('/api/clinics'), $data);

            $clinic = Clinic::query()
                ->where('name', $data['name'])
                ->firstOrFail();
            $response
                ->assertCreated()
                ->assertJson(
                    fn(AssertableJson $json): AssertableJson => $json->has(
                        'data',
                        fn(AssertableJson $json): AssertableJson => $json->whereAll(
                            ClinicResource::make($clinic)->resolve()
                        )
                    )
                );

            assertDatabaseHas('clinics', [
                'name' => $data['name'],
                'address' => $data['address'],
            ]);
    });

    it('can edit a clinic with the same address', function (): void {
        $existingClinic = ClinicFactory::new()->createOne();

        $data = StoreClinicRequestFactory::new()->create([
            'address' => $existingClinic->address,
        ]);

        $response = putJson(url("/api/clinics/$existingClinic->id"), $data);

        $response->assertOk();

        assertDatabaseHas('clinics', [
            'name' => $data['name'],
            'address' => $data['address'],
        ]);
    });
});
