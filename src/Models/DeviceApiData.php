<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceApiData extends Model
{


    use HasFactory, SoftDeletes;

    protected $fillable = [
        'device_id',
        'mode',
        'status',
        'fault_status',
        'output_injection_rate',
        'process_value',
        'setpoint',
        'tank_level',
        'working_pump',
        'flow_rate',
        'weight',
        'level_sensor',
        'network_status',
        'alerts',
        'option1',
        'option2',
        'option3',
        'option4',
        'special_text',
        'new_settings',
        'date_time',
    ];

    public function setDeviceIdAttribute($value)
    {
        $this->attributes['device_id'] = $value;
    }
}
