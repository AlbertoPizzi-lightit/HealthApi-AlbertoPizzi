<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function PHPUnit\Framework\assertEquals;

beforeEach(function (): void {
    $user = UserFactory::new()->createOne();
    actingAs($user);
});
describe('CancelUserAppointment', function (): void {
    it('deletes an appointment setting status to cancelled', function (): void {
        /** @var User $user */
        $user = Auth::user();
        $appointment = AppointmentFactory::new()->forUser($user)->createOne();
        $response = deleteJson("api/users/me/appointments/$appointment->id");
        $response->assertNoContent();
        /** @var Appointment $appointment */
        assertEquals(AppointmentStatus::Cancelled, $appointment->refresh()->status);
    });
    it('throws unauthorized action when trying to delete another users appointment', function (): void {
        /** @var User $user */
        $user = Auth::user();
        $user2 = UserFactory::new()->createOne();
        $appointment = AppointmentFactory::new()->forUser($user2)->createOne();

        $response = deleteJson("api/users/me/appointments/$appointment->id");
        $response->assertUnauthorized();
    });
});
