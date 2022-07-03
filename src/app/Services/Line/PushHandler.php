<?php

namespace App\Services\Line;

use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class PushHandler
{
    private CurlHTTPClient $httpClient;
    private LINEBot $bot;

    public function __construct()
    {
        $this->httpClient = new CurlHTTPClient(config('services.line.access_token'));
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => config('services.line.channel_secret')]);
    }

    /**
     * @param string $targetLineId
     * @param string $messages
     * @return void
     * @throws \Exception
     */
    public function pushTextMessages(string $targetLineId, string $messages): void
    {
        $builder = new LINEBot\MessageBuilder\TextMessageBuilder($messages);
        $res = $this->bot->pushMessage($targetLineId, $builder);

        if (!$res->isSucceeded()) {
            throw new \Exception(sprintf(
                'LINE push送信でエラーが発生しました。ステータスコード: %d, エラー内容: %s',
                $res->getHTTPStatus(),
                $res->getJSONDecodedBody()['message']
            ));
        }
    }
}
