<?php

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Stringable;
use DefStudio\Telegraph\DTO\User;

class Handler extends WebhookHandler
{
    public function hello(string $name): void
    {
        $this->reply(message: "Привет, $name!");
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if($text->value() === '/start') {
            $this->reply(message: 'Я готов к работе!');
        } else {
            $this->reply(message: 'Неизвестная команда');
        }
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $telegramUserData = $this->message?->from() ?->toArray();

        if ($telegramUserData) {
            // Создаем объект пользователя с использованием статического метода fromArray
            $user = User::fromArray($telegramUserData);

            // Получаем ID пользователя
            $userId = $user->id();

            // Отправляем ответ
            $this->reply("Ваш Telegram ID: $userId, сообщение: $text");
        } else {
            // Обработка ситуации, когда данные о пользователе недоступны
            $this->reply("Не удалось получить информацию о пользователе");
        }
    }

}
