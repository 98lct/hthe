<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_friends extends Model
{
    use HasFactory;
    protected $table    = 'user_friends';
    protected $primaryKey ='id';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'friend_id' => 'string',
        'accepted' => 'integer'
    ];
    protected $fillable = [
        'user_id',
        'friend_id',
        'accepted'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'user_id')->orWhere('user_id', '<>', $this->friend_id);
    // }

    // public function user_revert()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'user_id');
    // }

    // public function user()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public function user_id()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend_id()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
