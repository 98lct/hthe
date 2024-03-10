<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'source_id',
        'title',
        'is_read',
        'type',
        'notifiable_id',
        'notifiable_type',
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'source_id' => 'string',
        'notifiable_id' => 'string'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function source() {
        return $this->morphMany(Share::class, 'shareable');
    }
}
