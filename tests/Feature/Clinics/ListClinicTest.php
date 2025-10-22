<?php

declare(strict_types=1);

namespace Tests\Feature\Users;


use Database\Factories\ClinicFactory;
use function Pest\Laravel\getJson;

describe('clinics', function (): void {
    /** @see ListClinicController */

    it('can list users successfully', function (): void {
        $clinics = ClinicFactory::new()
            ->createMany(5);

        getJson(url('/api/clinics'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    });
});
