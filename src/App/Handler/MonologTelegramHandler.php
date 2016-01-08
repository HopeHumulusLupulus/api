<?php
namespace App\Handler;
use Monolog\Handler\MailHandler;
use Monolog\Handler\AbstractHandler;
use Telegram\Bot\Api;
class MonologTelegramHandler extends MailHandler {
    /**
     * 
     * @var Api
     */
    private $telegram;
    public function __construct(Api $telegram, $chat_id, $level = \Monolog\Logger::ERROR, $bubble = true) {
        $this->telegram = $telegram;
        $this->chat_id = $chat_id;
    }
    protected function send($content, array $records)
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $content,
            'disable_web_page_preview' => true
        ]);
    }
}