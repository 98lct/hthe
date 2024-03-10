<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $primaryKey = 'messageID';
    public $timestamps = false;
    protected $casts = [
        // 'send_time' => 'datetime',
        'senderID' => 'string',
        'receiverID' => 'string',
        'content' => 'string'

    ];
    protected $fillable = [
        'senderID',
        'receiverID',
        'content',
        'send_time'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiverID', 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderID', 'user_id');
    }


}
