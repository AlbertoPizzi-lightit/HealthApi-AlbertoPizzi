<?php

declare(strict_types=1);

namespace Lightit\Users\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class ClinicDoctorRelationException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'clinic_doctor_relation_error';

    protected $message = 'Doctor does not belong to this clinic';
}
