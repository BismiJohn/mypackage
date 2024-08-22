<?php

namespace App\Models;

use App\Models\maintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceTeams extends Model
{
    protected $primaryKey = 'team_id';

    public function maintenances()
    {
        return $this->hasMany(maintenance::class, 'team_id', 'team_id');
    }

    protected $fillable = [
        'name', 'contact_email', 'contact_phone',
    ];
}
