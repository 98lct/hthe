<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'body',
        'commentable_id',
        'commentable_type',
        'parent_id'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'commentable_id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class, 'commentable_id', 'post_id')->with('user');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }
}
