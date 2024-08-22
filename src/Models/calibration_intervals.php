<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration_intervals extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'calibration_intervals';
}
