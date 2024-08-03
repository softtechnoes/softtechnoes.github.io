<?php

namespace App\Http\Controllers\API;
use App\RabbitMQService;
use Illuminate\Http\Request;

class RabbitMqController
{
    public function publishMessage(Request $request)
    {
        $message = $request->input('message');
//        dd($message);

        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish($message);

        return response('Message published to RabbitMQ');
    }

    public function consumeMessage()
    {
        $rabbitMQService = new RabbitMQService();

        $callback = function ($msg) {
            echo "Received message: " . $msg->body . "\n";
        };

        $rabbitMQService->consume($callback);
        return response('Message published to RabbitMQ');
    }
}
