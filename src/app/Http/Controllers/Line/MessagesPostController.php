<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use App\Services\Line\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;

class MessagesPostController extends Controller
{
    public function __construct(private Handler $lineHandler)
    {
        $this->lineHandler = $lineHandler;
    }

    public function __invoke(Request $request)
    {
        $signature = $request->headers->get(LINEBot\Constant\HTTPHeader::LINE_SIGNATURE);
        if (! LINEBot\SignatureValidator::validateSignature($request->getContent(), config('services.line.channel_secret'), $signature)) {
            abort(400);
        }

        try {
            $this->lineHandler->reply($this->lineHandler->parseEventRequests(
                requestBody: $request->getContent(),
                signature: $signature
            ));
            return response()->json([
                'res' => 'ok'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            abort(500);
        }
    }
}
