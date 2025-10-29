<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Clinics\Domain\Models\Clinic;

final class AssignClinicRequest extends FormRequest
{
    public const string CLINIC_ID = 'clinic_id';

    public function rules(): array
    {
        return [
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
        ];
    }
    public function getClinicId(): int{
        return $this->integer(self::CLINIC_ID);
    }
}
