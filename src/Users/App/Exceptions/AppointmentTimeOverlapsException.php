<?php

declare(strict_types=1);

namespace Lightit\Users\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class AppointmentTimeOverlapsException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'time_overlaps_error';

    protected $message = 'This overlaps with another appointment';
}
