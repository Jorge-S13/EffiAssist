<?php
///** @var SergiX44\Nutgram\Nutgram $bot */
//
//use App\Telegram\Conversations\TaskConversation;
//use App\Telegram\Handlers\ExceptionHandler;
//use App\Telegram\Handlers\UpdateChatStatusHandler;
//use App\Telegram\Middleware\CheckMaintenance;
//use App\Telegram\Middleware\CollectChat;
//use SergiX44\Nutgram\Nutgram;
//
///*
//|--------------------------------------------------------------------------
//| Nutgram Handlers
//|--------------------------------------------------------------------------
//|
//| Here is where you can register telegram handlers for Nutgram. These
//| handlers are loaded by the NutgramServiceProvider. Enjoy!
//|
//*/
//
///*
//|--------------------------------------------------------------------------
//| Global middlewares
//|--------------------------------------------------------------------------
//*/
//
//$bot->middleware(CollectChat::class);
//$bot->middleware(CheckMaintenance::class);
//
///*
//|--------------------------------------------------------------------------
//| Bot commands
//|--------------------------------------------------------------------------
//*/
//
//$bot->onCommand('start', function (Nutgram $bot) {
//    $bot->sendMessage('Hello, world!');
//})->description('The start command!');
//
////$bot->onCommand('addtask', TaskConversation::class)->description('Add new task');
//
///*
//|--------------------------------------------------------------------------
//| Bot handlers
//|--------------------------------------------------------------------------
//*/
//
//$bot->onMyChatMember(UpdateChatStatusHandler::class);
///*
//|--------------------------------------------------------------------------
//| Exception handlers
//|--------------------------------------------------------------------------
//*/
//$bot->onApiError(ExceptionHandler::class);
//$bot->onException(ExceptionHandler::class);
