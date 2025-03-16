<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use WebSocket\Client;

Route::get('/test', function (Request $request) {
    try {
        $client = new Client("wss://stream.binance.com:9443/ws/btcusdt@trade");

        while (true) {
            $data = json_decode($client->receive(), true);
            dump($data);
            sleep(2);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
});
