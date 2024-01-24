<?php

namespace App\Services;

use SergiX44\Nutgram\Nutgram;

class TaskService
{
    public function textValidation(Nutgram $bot, $messageText, $method)
    {
        if ($bot->message()?->text === null && $bot->message()->from->is_bot === false) {
            $bot->sendMessage(
                text: $messageText,
            );
            $method();

            return;
        }
    }
}
