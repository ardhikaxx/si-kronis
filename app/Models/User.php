<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // User Profiles
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function nurseProfile()
    {
        return $this->hasOne(NurseProfile::class);
    }

    // Patient Relationships
    public function chronicConditions()
    {
        return $this->hasMany(PatientChronicCondition::class, 'user_id');
    }

    public function patientChronicConditions()
    {
        return $this->hasMany(PatientChronicCondition::class);
    }

    public function bookingsAsPatient()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }

    public function consultationsAsPatient()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class, 'patient_id');
    }

    public function prescriptionsAsPatient()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function ratingsAsPatient()
    {
        return $this->hasMany(Rating::class, 'patient_id');
    }

    // Doctor Relationships
    public function bookingsAsDoctor()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }

    public function consultationsAsDoctor()
    {
        return $this->hasMany(Consultation::class, 'doctor_id');
    }

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function doctorLeaves()
    {
        return $this->hasMany(DoctorLeave::class, 'doctor_id');
    }

    public function prescriptionsAsDoctor()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    public function ratingsAsDoctor()
    {
        return $this->hasMany(Rating::class, 'doctor_id');
    }

    // Admin/Staff Relationships
    public function bookingsConfirmed()
    {
        return $this->hasMany(Booking::class, 'confirmed_by');
    }

    public function bookingsCancelled()
    {
        return $this->hasMany(Booking::class, 'cancelled_by');
    }

    public function labResultsReviewed()
    {
        return $this->hasMany(LabResult::class, 'reviewed_by');
    }

    public function labResultsUploaded()
    {
        return $this->hasMany(LabResult::class, 'uploaded_by');
    }

    public function prescriptionsDispensed()
    {
        return $this->hasMany(Prescription::class, 'dispensed_by');
    }

    // Other Relationships
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
