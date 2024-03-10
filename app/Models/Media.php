<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = 'medias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'media_id',
        'type',
        'src',
        'mediable_id',
        'mediable_type',
        'status',
        'is_delete',
        'url'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'media_id' => 'string',
        'mediable_id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
