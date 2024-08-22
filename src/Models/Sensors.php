<?php

namespace App\Models;

use App\Models\maintenance;
use App\Models\ServiceTeams;
use App\Models\Calibration_intervals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sensors extends Model
{
    protected $primaryKey = 'sensor_id';

    // Add the fillable property
    protected $fillable = [
        'project_id',
        'sensor_type',
        'location_id',
        'installation_date',
        'status',
        'warranty_date',
        'maintainor',
        'calibration_frequency',
        'location_name',
        'latitude',
        'longitude',
    ];

    // Define the inverse relationship to the Maintenance model
    public function maintenances()
    {
        return $this->hasMany(maintenance::class, 'sensor_id', 'sensor_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'project_id');
    }

    public function maintainors()
    {
        return $this->belongsTo(ServiceTeams::class, 'maintainor','team_id');
    }

    public function calibrationInterval()
    {
        return $this->belongsTo(Calibration_intervals::class, 'calibration_frequency','id');
    }
}
