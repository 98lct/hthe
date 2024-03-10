<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table    = 'pages';
    protected $primaryKey ='id';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'page_id' => 'string'

    ];
    protected $fillable = [
        'user_id',
        'page_id',
        'name',
        'pagename',
        'subject',
        'profile_img',
        'status',
        'cover_img'
    ];
}
