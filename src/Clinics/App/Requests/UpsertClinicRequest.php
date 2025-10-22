<?php

namespace Lightit\Clinics\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Clinics\Domain\DataTransferObjects\ClinicDto;

class UpsertClinicRequest extends FormRequest
{
    public const string NAME = 'name';

    public const string ADDRESS = 'address';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'min:4', 'max:80'],
            self::ADDRESS => ['required', 'string', 'min:4', 'max:80']
        ];
    }

    public function toDto(): ClinicDto
    {
        return new ClinicDto(
            name: $this->string(self::NAME)->toString(),
            address: $this->string(self::ADDRESS)->toString(),
        );
    }
}
