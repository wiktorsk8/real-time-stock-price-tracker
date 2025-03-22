<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use WebSocket\Client;
use Illuminate\Support\Facades\Redis;

Route::get('/stockData', function (Request $request) {
    ob_start();
    $client = new Client("wss://stream.binance.com:9443/ws/btcusdt@trade");
    return response()->stream(function () use ($client): void {
        while (true) {
            $data = $client->receive();
            echo "data: " . $data . "\n\n";
            ob_flush();
            flush();
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',   // SSE content type
        'Cache-Control' => 'no-cache',           // No caching
        'Connection' => 'keep-alive',           // Keep the connection open
    ]);
});

Route::get('/activeUsers', function (Request $request) {
    ob_start();
    return response()->stream(function (): void {
        while (true) {

            echo "data: " . 'duppa' . "\n\n";
            ob_flush();
            flush();
            sleep(1);
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',   // SSE content type
        'Cache-Control' => 'no-cache',           // No caching
        'Connection' => 'keep-alive',           // Keep the connection open
    ]);
});

Route::post('/user/ping', function (Request $request) {
    $cacheKey = 'active_user';
    $userId = $request->header('user-id');
    Log::info("$cacheKey:$userId", ['user' => Redis::keys("$cacheKey")]);
    $user = Cache::get("$cacheKey:$userId");
    if (!$user) {
        Cache::put("$cacheKey:$userId", now(), 1); // 1 second TTL
    }
});


Route::get('/', function () {
    return Inertia::render('Home', ['message' => 'Hello from Laravel!']);
});


