<?php

namespace App\Telegram\Conversations;



use App\Models\Chat;
use App\Models\Task;
use App\Services\TaskService;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class TaskConversation extends Conversation
{
    protected ?string $title;
    protected ?string $description;
    protected int $priority;
    protected int $dueDate;

    protected int $chat_id;
    protected int $message_id;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function start(Nutgram $bot)
    {
        $message = $bot->sendMessage(
            text: 'Давайте добавим товое задание. Для начала отправьте заголовок вашего задания.',
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(InlineKeyboardButton::make(text: 'Отменить', callback_data: 'title.cancel')),
        );

        $this->chat_id = $message->chat->id;
        $this->message_id = $message->message_id;

        $this->setSkipHandlers(true)->next('setTitle');
    }

    public function setTitle(Nutgram $bot)
    {
        if ($bot->isCallbackQuery() && $bot->callbackQuery()->data === 'title.cancel') {
            $bot->answerCallbackQuery();
            $this->end();

            return;
        }
        //check valid input
        $this->taskService->textValidation($bot, 'message text', function () use ($bot) {
            $this->start($bot);
        });
        if ($bot->message()?->text === null && $bot->message()->from->is_bot === false ) {
            $bot->sendMessage(
                text: 'Невенрый формать заголовка',
            );
            $this->start($bot);

            return;
        }

        //get the input
        $this->title = $bot->message()?->text;


        $bot->sendMessage('Хорошо! Теперь давайте добавим описание задания');

        $this->setSkipHandlers(true)->next('setDescriprion');
    }
    public function setDescriprion(Nutgram $bot)
    {
        //check valid input
        if ($bot->message()?->text === null) {
            $bot->sendMessage(
                text: 'Невенрый формать заголовка',
            );
            $this->setTitle($bot);

            return;
        }
        //get the input
        $this->description = $bot->message()?->text;

        $bot->sendMessage('Отлично! Давай выберим приоритет задания. Отправь цифру от 1 до 5');

        $this->setSkipHandlers(true)->next('setPriority');
    }

    public function setPriority(Nutgram $bot)
    {
        //check valid input
        if ($bot->message()?->text === null) {
            $bot->sendMessage(
                text: 'Невенрый формать описания',
            );
            $this->setDescriprion($bot);

            return;
        }
        //get the input
        $this->priority = $bot->message()?->text;

        $bot->sendMessage('Отлично! Давай выберим день когда нужно выполнить задание. Отправь цифру от 1 до 5');

        $this->setSkipHandlers(true)->next('setDueDate');
    }

    public function setDueDate(Nutgram $bot)
    {
        //check valid input
        if ($bot->message()?->text === null) {
            $bot->sendMessage(
                text: 'Невенрый формать описания',
            );
            $this->setPriority($bot);

            return;
        }
        //get the input
        $this->dueDate = $bot->message()?->text;
        $bot->sendMessage('Почти готово');
        $this->end();
    }
    public function closing(Nutgram $bot)
    {
//        $chat = $bot->get(Chat::class);
        try {
            $task = Task::updateOrCreate([
                'title' => $this->title,
                'description' => $this->description,
                'priority' => $this->priority,
                'due_date' => now(),
                'chat_id' => $bot->chat()->id,
            ]);
        } catch (\Exception $exception) {
            $this->start($bot);
        }
        $task->save();
        $bot->sendMessage('Всё готово!');
        $bot->deleteMessage($this->chat_id, $this->message_id);
    }
}
