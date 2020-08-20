<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Appointment extends Model
{
    //
    protected $fillable = [
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type',
        'status'
    ];

    // define por defecto una columna como objeto carbon
/*
    protected $dates = [
        'scheduled_date',
    ];
*/
    public function specialty(){

        return $this->belongsTo(Specialty::class);
    }

    public function doctor(){

        return $this->belongsTo(User::class);
    }

    public function patient(){

        return $this->belongsTo(User::class);
    }

    public function cancellation(){

        return $this->hasOne(CancelledAppointment::class);
    }
    // accesor
    // $appointment->scheduled_time_12
    public function getScheduledTime12Attribute(){

        $scheduled_time = new Carbon($this->scheduled_time);

        return $scheduled_time->format('g:i A');
    }

}
