<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Models;

use Carbon\CarbonImmutable;
use DateTime;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $doctor_id
 * @property int $patient_id
 * @property int $clinic_id
 * @property CarbonImmutable|null     $start_time
 * @property CarbonImmutable|null     $end_time
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static Builder<static>|Appointment newModelQuery()
 * @method static Builder<static>|Appointment newQuery()
 * @method static Builder<static>|Appointment query()
 * @method static Builder<static>|Appointment whereClinic($value)
 * @method static Builder<static>|Appointment whereCreatedAt($value)
 * @method static Builder<static>|Appointment whereDoctor($value)
 * @method static Builder<static>|Appointment whereEndTime($value)
 * @method static Builder<static>|Appointment whereId($value)
 * @method static Builder<static>|Appointment wherePatient($value)
 * @method static Builder<static>|Appointment whereStartTime($value)
 * @method static Builder<static>|Appointment whereUpdatedAt($value)
 * @method static Builder<static>|Appointment whereClinicId($value)
 * @method static Builder<static>|Appointment whereDoctorId($value)
 * @method static Builder<static>|Appointment wherePatientId($value)
 *
 * @property int $user_id
 *
 * @method static Builder<static>|Appointment whereUserId($value)
 *
 * @mixin Eloquent
 */
class Appointment extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<dateTime, dateTime>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'immutable_datetime',
            'end_time' => 'immutable_datetime',
        ];
    }
}
