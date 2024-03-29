<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SergiX44\Nutgram\Telegram\Types\User\User;

class Chat extends Model
{
    protected $primaryKey = 'chat_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static $unguarded = true;
    protected $casts = [
        'started_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class,'chat_id','chat_id');
    }
    public static function findFromUser(?User $user): ?Chat
    {
        if ($user === null) {
            return null;
        }

        $chat = self::find($user->id);

        return $chat ?? null;
    }
}
