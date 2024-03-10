<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'shared_by',
        'postable_id',
        'postable_type',
        'status',
        'is_delete',
        'feeling',
        'activity'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'postable_id' => 'string',
        'post_id' => 'string'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function page()
    {
        return $this->belongsTo(Page::class, 'postable_id' ,'page_id');
    }
    public function medias() {
        return $this->morphMany(Media::class, 'mediable')->with('user');
    }
    public function reacts() {
        return $this->morphMany(React::class, 'reactable')->with('user');
    }
    public function shares() {
        return $this->morphMany(Share::class, 'shareable')->with('user', 'page');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->orWhere('parent_id', 0)->with('user', 'post');
    }
    public function shared()
    {
        return $this->hasOne(Post::class, 'post_id', 'shared_by')->with('user', 'medias', 'page');
    }
    public function feelings()
    {
        return $this->hasOne(Feeling::class, 'feel_id', 'feeling');
    }
    public function activitys()
    {
        return $this->hasOne(Feeling::class, 'feel_id', 'activity');
    }
    public function locations()
    {
        return $this->hasOne(Location::class, 'location_id', 'location_id');
    }
}
