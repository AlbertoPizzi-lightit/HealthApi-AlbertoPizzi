<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StoreUserAppointmentAction
{
    public function execute(AppointmentDto $appointmentDto): Appointment
    {
        $appointment = new Appointment();

        $this->doctorClinicValidator($appointmentDto);
        $this->noOverlapValidator($appointmentDto);

        $appointment->user_id = $appointmentDto->userId;
        $appointment->doctor_id = $appointmentDto->doctorId;
        $appointment->clinic_id = $appointmentDto->clinicId;
        $appointment->start_time = $appointmentDto->startTime;
        $appointment->end_time = $appointmentDto->endTime;

        $appointment->saveOrFail();


        return $appointment;
    }

    private function doctorClinicValidator(AppointmentDto $appointmentDto): void
    {
        $doctor = Doctor::query()->findOrFail($appointmentDto->doctorId);
        if (! $doctor->clinics()->where('clinic_id', $appointmentDto->clinicId)->exists()) {
            throw new BadRequestHttpException();
        }
    }

    private function noOverlapValidator(AppointmentDto $appointmentDto): void
    {
        $appointmentFound = Appointment::query()->where('start_time', '<=', $appointmentDto->startTime)
            ->where('end_time', '>=', $appointmentDto->endTime)
            ->where(function (\Illuminate\Contracts\Database\Query\Builder $query) use ($appointmentDto): void {
                $query->where('doctor_id', '=', $appointmentDto->doctorId)
                    ->orWhere('user_id', '=', $appointmentDto->userId);
            })
            ->where('status', '=', AppointmentStatus::Confirmed->value);

        if ($appointmentFound->exists()) {
            throw new BadRequestHttpException();
        }
    }
}
