<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
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
        should create it', function (): void {
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
    it('throws an exception when trying to store an overlapping appointment for the same user', function (): void {
        /** @var User $user */
        $user = Auth::user();
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor->clinics()->syncWithoutDetaching($clinic->id);
        $startTime = CarbonImmutable::now();
        $endTime = $startTime->addHour();

        $response = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status'=> AppointmentStatus::Confirmed,
        ]);
        $response2 = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $response2->assertStatus(JsonResponse::HTTP_CONFLICT);
    });
    it('throws an exception when trying to store an overlapping appointment for the same doctor', function (): void {
        /** @var User $user */
        $user = Auth::user();
        $doctor = DoctorFactory::new()->createOne();
        $clinic = ClinicFactory::new()->createOne();
        $doctor->clinics()->syncWithoutDetaching($clinic->id);
        $startTime = CarbonImmutable::now();
        $endTime = $startTime->addHour();

        $response = postJson('api/users/me/appointments', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $user2 = UserFactory::new()->createOne();
        actingAs($user2);

        $response2 = postJson('api/users/me/appointments', [
            'user_id' => $user2->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status'=> AppointmentStatus::Confirmed,
        ]);

        $response2->assertStatus(JsonResponse::HTTP_CONFLICT);
    });
})->only();
