<?php

namespace App\Console\Commands\Line;

use App\Services\Line\PushHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PushMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tatsukoni-pra:push_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Line Messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(PushHandler $pushHandler)
    {
        try {
            $pushHandler->pushTextMessages(
                targetLineId: 'hogehoge', // 送信対象のLINEユーザIDに書き換える。
                messages: 'テストメッセージ'
            );
            return 0;
        } catch (\Exception $e) {
            Log::error($e);
            return 1;
        }
    }
}
