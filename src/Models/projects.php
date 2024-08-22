<?php

namespace App\Models;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Projects extends Model
{

    protected $primaryKey = 'project_id';
    protected $fillable = ['customer_id', 'name', 'description', 'start_date', 'project_location_details'];

    // Define the 'customer' relationship
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'customer_id');
    }
}
