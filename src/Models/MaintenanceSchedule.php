<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['device_id', 'calibration_id','maintenance_date','deleted_at'];
    protected $dates = ['deleted_at'];
}
