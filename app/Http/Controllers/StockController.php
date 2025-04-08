<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;
use WebSocket\Client;

class StockController extends Controller
{
    public function stockData(): StreamedResponse
    {
        ini_set('output_buffering', 'off');
        ini_set('zlib.output_compression', 'off');

        $client = new Client("wss://stream.binance.com:9443/ws/btcusdt@trade");
        $response = new StreamedResponse(function () use ($client) {
            while (true) {
                $data = $client->receive();

                echo "data: $data\n\n";

                while (ob_get_level() > 0) ob_end_flush();
                flush();

                $rate = (float)(Cache::get('rate') ?? 1);

                usleep($rate * 1000000);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    public function updateStockRate(): void
    {
        request()->validate([
            'rate' => 'required|decimal:0,2',
        ]);
        $rate = request()->input('rate');
        Cache::put('rate', $rate);
    }
}