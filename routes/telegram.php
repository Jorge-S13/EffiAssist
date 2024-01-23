<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Handlers\UpdateChatStatusHandler;
use App\Telegram\Middleware\CheckMaintenance;
use App\Telegram\Middleware\CollectChat;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

/*
|--------------------------------------------------------------------------
| Global middlewares
|--------------------------------------------------------------------------
*/

$bot->middleware(CollectChat::class);
$bot->middleware(CheckMaintenance::class);

/*
|--------------------------------------------------------------------------
| Bot commands
|--------------------------------------------------------------------------
*/

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hello, world!');
})->description('The start command!');

/*
|--------------------------------------------------------------------------
| Bot handlers
|--------------------------------------------------------------------------
*/

$bot->onMyChatMember(UpdateChatStatusHandler::class);
/*
|--------------------------------------------------------------------------
| Exception handlers
|--------------------------------------------------------------------------
*/
