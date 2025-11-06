<?php

declare(strict_types=1);

namespace Lightit\Users\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
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

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer', Rule::exists(Doctor::class, 'id')],
            self::USER_ID => ['required', 'integer', Rule::exists(User::class, 'id')],
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
            self::START_TIME => ['required', Rule::date()->after(CarbonImmutable::now())],
            self::END_TIME => ['required', Rule::date()->after(self::START_TIME)],
            ];
    }

    public function toDto(): AppointmentDto
    {
        $startsAt = CarbonImmutable::parse(
            $this->string(self::START_TIME)->toString()
        );
        $endsAt = CarbonImmutable::parse(
            $this->string(self::END_TIME)->toString()
        );

        return new AppointmentDto(
            userId: $this->integer(self::USER_ID),
            doctorId: $this->integer(self::DOCTOR_ID),
            clinicId: $this->integer(self::CLINIC_ID),
            startTime: $startsAt,
            endTime: $endsAt,
        );
    }
}
