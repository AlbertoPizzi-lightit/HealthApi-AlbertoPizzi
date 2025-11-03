<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Models;

use Carbon\CarbonImmutable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

/**
 * @property int                  $id
 * @property int                  $doctor_id
 * @property int                  $patient_id
 * @property int                  $clinic_id
 * @property CarbonImmutable|null $start_time
 * @property CarbonImmutable|null $end_time
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

    protected function casts(): array
    {
        return [
            'start_time' => 'immutable_datetime',
            'end_time' => 'immutable_datetime',
        ];
    }

    /**
     * @return HasOne<Clinic, $this>
     */
    public function clinics():HasOne{
        return $this->hasOne(Clinic::class);
    }

    /**
     * @return HasOne<Doctor , $this>
     */
    public function doctors():HasOne{
        return $this->hasOne(Doctor::class);
    }

    /**
     * @return BelongsToMany<User , $this>
     */
    public function users():BelongsToMany{
        return $this->belongsToMany(User::class);
    }

}
