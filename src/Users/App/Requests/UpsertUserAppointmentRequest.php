<?php

declare(strict_types=1);

namespace Lightit\Users\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Enums\AppointmentStatus;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

class UpsertUserAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public const string USER_ID = 'user_id';

    public const string CLINIC_ID = 'clinic_id';

    public const string START_TIME = 'start_time';

    public const string END_TIME = 'end_time';

    public const string STATUS = 'status';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer', Rule::exists(Doctor::class, 'id')],
            self::USER_ID => ['required', 'integer', Rule::exists(User::class, 'id')],
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
            self::START_TIME => ['required', 'date', 'after:now'],
            self::END_TIME => ['required', 'date', 'after:start_time'],
            self::STATUS => ['default', 'value' => AppointmentStatus::Confirmed ->value],
            ];
    }

    public function getDoctorId(): int
    {
        return $this->integer(self::DOCTOR_ID);
    }

    public function getUserId(): int
    {
        return $this->integer(self::USER_ID);
    }

    public function getClinicId(): int
    {
        return $this->integer(self::CLINIC_ID);
    }

    public function toDto(): AppointmentDto
    {
        /**
         * @var CarbonImmutable $startsAt
         */
        $startsAt = $this->date(self::START_TIME)?->toImmutable();
        /**
         * @var CarbonImmutable $endsAt
         */
        $endsAt = $this->date(self::END_TIME)?->toImmutable();

        return new AppointmentDto(
            userId: $this->string(self::USER_ID)->toInteger(),
            doctorId: $this->string(self::DOCTOR_ID)->toInteger(),
            clinicId: $this->string(self::CLINIC_ID)->toInteger(),
            startTime: $startsAt,
            endTime: $endsAt,
        );
    }
}
