<?php

namespace App\Models;

use App\Models\Sensors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alerts extends Model
{
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'alert_type',
        'alert_message',
        'status',
    ];

    public function sensors()
    {
        return $this->belongsTo(Sensors::class, 'sensor_id','sensor_id');
    }
}
