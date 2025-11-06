<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Users\Domain\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function (): void {
    $user = UserFactory::new()->createOne();
    actingAs($user);
});
describe('StoreUserAppointment', function (): void {
    it('when attempting to store an appointment as a authenticated user,
        should create it', function () {
        /** @var User $user */
        $user = Auth::user();
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor->clinics()->syncWithoutDetaching($clinic);

        $response = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => now(),
            'end_time' => now()->addDay(),
            'status'=> AppointmentStatus::Confirmed,
        ])
        ->assertCreated();
        assertDatabaseHas('appointments', [
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'user_id' => $user->id,
            'start_time' => now(),
            'end_time' => now()->addDay(),
            'status'=> AppointmentStatus::Confirmed,
        ]);
    });
    it('throws an exception when trying to store an overlapping appointment for the same user', function () {
        /** @var User $user */
        $user = Auth::user();
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor->clinics()->syncWithoutDetaching($clinic->id);
        $start_time = "2025-11-12T03:40:58.000000Z";
        $end_time = "2025-11-12T04:40:58.000000Z";

        $response = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status'=> AppointmentStatus::Confirmed,
        ]);
        $response2 = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $response2->assertStatus(JsonResponse::HTTP_CONFLICT);
    });
    it('throws an exception when trying to store an overlapping appointment for the same doctor', function () {
        /** @var User $user */
        $user = Auth::user();
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor->clinics()->syncWithoutDetaching($clinic->id);
        $start_time = "2025-11-12T03:40:58.000000Z";
        $end_time = "2025-11-12T04:40:58.000000Z";

        $response = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $user2 = UserFactory::new()->createOne();
        actingAs($user2);

        $response2 = postJson('api/users/me/appointments', [
            'user_id' => $user2->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $response2->assertStatus(JsonResponse::HTTP_CONFLICT);
    });
});
