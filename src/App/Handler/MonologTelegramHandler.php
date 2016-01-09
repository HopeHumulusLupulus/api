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
    public function __construct($arguments, $level = \Monolog\Logger::ERROR, $bubble = true) {
        $this->arguments = $arguments;
    }
    protected function send($content, array $records)
    {
        pclose(popen('php '.$this->arguments['command'].
            base64_encode(serialize([
                'params' => [
                    'chat_id' => $this->arguments['chat_id'],
                    'text' => getenv('APP_ENV').'->'.$content,
                    'disable_web_page_preview' => true
                ],
                'token' => $this->arguments['token']
            ])).' &', 'r'
        ));
    }
}