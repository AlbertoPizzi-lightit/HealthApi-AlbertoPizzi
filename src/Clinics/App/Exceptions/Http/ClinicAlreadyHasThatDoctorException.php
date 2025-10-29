<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Exceptions\Http;

use Lightit\Shared\App\Exceptions\Http\HttpException;

class ClinicAlreadyHasThatDoctorException extends HttpException
{
    /**
     * An HTTP status code.
     */
    protected int $status = 409;

    /**
     * An error code.
     */
    protected string $errorCode = 'relation_already_exists';
}
