<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = 'location_id';

    // Define the relationship to the Sensors model
    public function sensors()
    {
        return $this->hasMany(Sensors::class, 'location_id', 'location_id');
    }
}
