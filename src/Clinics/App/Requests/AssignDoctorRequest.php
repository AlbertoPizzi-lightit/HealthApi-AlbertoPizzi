<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Doctors\Domain\Models\Doctor;

class AssignDoctorRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer', Rule::exists(Doctor::class, 'id')],
        ];
    }
}
