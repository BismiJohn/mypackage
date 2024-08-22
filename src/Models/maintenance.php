<?php

namespace App\Models;

use App\Models\serviceTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    protected $table='maintenance_records';
    protected $primaryKey = 'maintenance_id'; // Specify the correct primary key

    protected $fillable = [
        'sensor_id', 'team_id', 'description', 'maintenance_date', 'status'
    ];
    protected $guarded = [];

    public function sensor()
    {
        return $this->belongsTo(Sensors::class, 'sensor_id', 'sensor_id');
    }

    public function serviceTeam()
    {
        return $this->belongsTo(serviceTeams::class, 'team_id', 'team_id');
    }
}
