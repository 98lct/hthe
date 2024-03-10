<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend_requests extends Model
{
    use HasFactory;
    protected $table    = 'friend_requests';
    protected $primaryKey ='id';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'requested_by' => 'string'
    ];
    protected $fillable = [
        'status',
        'user_id',
        'requested_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by', 'user_id');
    }
}
