<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Illuminate\Database\Eloquent\Builder;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\App\Exceptions\AppointmentTimeOverlapsException;
use Lightit\Users\App\Exceptions\ClinicDoctorRelationException;
use Lightit\Users\App\Notifications\UserAppointmentCreatedNotification;

class StoreUserAppointmentAction
{
    public function execute(AppointmentDto $appointmentDto): Appointment
    {
        $appointment = new Appointment();

        $this->validateDoctorClinicAssociation($appointmentDto);
        $this->validateAppointmentOverlap($appointmentDto);

        $appointment->user_id = $appointmentDto->userId;
        $appointment->doctor_id = $appointmentDto->doctorId;
        $appointment->clinic_id = $appointmentDto->clinicId;
        $appointment->start_time = $appointmentDto->startTime;
        $appointment->end_time = $appointmentDto->endTime;
        $appointment->status = AppointmentStatus::Confirmed;

        $appointment->saveOrFail();

        $appointment->user->notify(new UserAppointmentCreatedNotification());

        return $appointment;
    }

    private function validateDoctorClinicAssociation(AppointmentDto $appointmentDto): void
    {
        $doctor = Doctor::query()->findOrFail($appointmentDto->doctorId);
        $doctorWorksInClinic = $doctor->clinics()->where('clinic_id', $appointmentDto->clinicId)->exists();

        if (! $doctorWorksInClinic) {
            throw new ClinicDoctorRelationException();
        }
    }

    private function validateAppointmentOverlap(AppointmentDto $appointmentDto): void
    {
        $overlappingAppointment = Appointment::query()->where('start_time', '<=', $appointmentDto->startTime)
            ->where('end_time', '>=', $appointmentDto->endTime)
            ->where(function (Builder $query) use ($appointmentDto): void {
                $query->where('doctor_id', $appointmentDto->doctorId)
                    ->orWhere('user_id', $appointmentDto->userId);
            })
            ->where('status', AppointmentStatus::Confirmed);

        if ($overlappingAppointment->exists()) {
            throw new AppointmentTimeOverlapsException();
        }
    }
}
