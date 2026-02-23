<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceLogs extends Model
{
    protected $fillable = [
        'biometric_id',
        'dtr_date',
        'date_time',
        'status',
        'is_Shifting',
        'schedule',
        'active',
        'device_name'
    ];
}
