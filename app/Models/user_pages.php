<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_pages extends Model
{
    use HasFactory;
    protected $table    = 'user_pages';
    protected $primaryKey ='id';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'user_id' => 'string',
        'page_id' => 'string'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'page_id');
    }
}
