<?php

namespace App\Services\Line;

use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Handler
{
    private CurlHTTPClient $httpClient;
    private LINEBot $bot;

    public function __construct()
    {
        $this->httpClient = new CurlHTTPClient(config('services.line.access_token'));
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => config('services.line.channel_secret')]);
    }

    /**
     * @param $requestBody
     * @param string $signature
     * @return [LINEBot\Event\BaseEvent]
     */
    public function parseEventRequests($requestBody, string $signature): array
    {
        return $this->bot->parseEventRequest($requestBody, $signature);
    }

    /**
     * @param [LINEBot\Event\BaseEvent] $events
     * @return void
     */
    public function reply(array $events): void
    {
        foreach ($events as $event) {
            // Log::debug($event);
            $this->bot->replyText($event->getReplyToken(), $this->getReplyMessage($event));
        }
    }

    /**
     * @param LINEBot\Event\BaseEvent $event
     * @return string
     */
    private function getReplyMessage(LINEBot\Event\BaseEvent $event): string
    {
        switch (true) {
            case $event instanceof LINEBot\Event\MessageEvent\TextMessage:
                return $this->getReplyMessageFromTextMessage($event);
            default:
                return '未定義の操作です';
        }
    }

    /**
     * @param LINEBot\Event\MessageEvent\TextMessage $textMessageevent
     * @return string
     */
    private function getReplyMessageFromTextMessage(LINEBot\Event\MessageEvent\TextMessage $textMessageevent): string
    {
        $replyMessage = "送信ありがとうございます。\n";
        $userSendMessage = $textMessageevent->getText();

        // 送信メッセージ内容に応じて、返信内容を可変させる
        if ($userSendMessage === 'tatsukoni') {
            $replyMessage .= 'sample';
        } else {
            $replyMessage .= 'dummy';
        }

        return $replyMessage;
    }
}
