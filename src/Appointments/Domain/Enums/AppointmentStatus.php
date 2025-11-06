<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Enums;

enum AppointmentStatus: string
{
    case Cancelled = 'cancelled';
    case Confirmed = 'confirmed';
}
