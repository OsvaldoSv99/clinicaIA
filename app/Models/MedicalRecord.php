<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'diagnosis',
        'indications',
        'next_appointment_date',
        'signature_path',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'next_appointment_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
