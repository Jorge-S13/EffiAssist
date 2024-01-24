<?php

namespace App\Http\Controllers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

class BotController extends Controller
{
    public function __invoke(Nutgram $bot)
    {

        $bot->setRunningMode(Webhook::class);
        $bot->onCommand('start', function (Nutgram $bot) {
            $bot->sendMessage('Hello, Bro 123');
        });
        $bot->run();
    }
}
