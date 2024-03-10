<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    protected $casts = [
        // 'feel_id' => 'string'
    ];
    protected $fillable = [
        'location_name', 'location_short_name', 'location_key'
    ];
}
