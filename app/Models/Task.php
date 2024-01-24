<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected static $unguarded = true;
    public function chats()
    {
        return $this->belongsTo(Chat::class,'chat_id','chat_id');
    }
}
