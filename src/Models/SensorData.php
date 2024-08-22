<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id', 'timestamp', 'value', 'unit',
    ];
    protected $primaryKey = 'data_id';

    protected $table = 'sensor_data';
}
