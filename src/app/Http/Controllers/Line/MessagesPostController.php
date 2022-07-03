<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;

class MessagesPostController extends Controller
{
    private CurlHTTPClient $httpClient;
    private LINEBot $bot;

    public function __construct()
    {
        $this->httpClient = new CurlHTTPClient(config('services.line.access_token'));
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => config('services.line.channel_secret')]);
    }

    public function __invoke(Request $request)
    {
        Log::debug($request);
        $request->collect('events')->each(function ($event) {
            $this->bot->replyText($event['replyToken'], $event['message']['text']);
        });
        return [
            [
                'res' => 'ok',
            ]
        ];
    }
}
