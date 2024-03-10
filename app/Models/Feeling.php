<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeling extends Model
{
    use HasFactory;
    protected $table = 'feelings';
    protected $primaryKey = 'feel_id';
    protected $casts = [
        // 'feel_id' => 'string'
    ];
    protected $fillable = [
        'feel_id', 'feel_name', 'feel_icon', 'feel_class'
    ];
}
