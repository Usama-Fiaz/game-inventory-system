<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher
{
    protected string $host;
    protected int $port;
    protected string $user;
    protected string $password;
    protected string $exchange;

    public function __construct()
    {
        $this->host = env('RABBITMQ_HOST', '127.0.0.1');
        $this->port = (int) env('RABBITMQ_PORT', 5672);
        $this->user = env('RABBITMQ_USER', 'guest');
        $this->password = env('RABBITMQ_PASSWORD', 'guest');
        $this->exchange = env('RABBITMQ_EXCHANGE', 'inventory_events');
    }

    public function publish(string $routingKey, array $payload): void
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
        $channel = $connection->channel();

        $channel->exchange_declare($this->exchange, 'topic', false, true, false);

        $msgBody = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $message = new AMQPMessage($msgBody, ['content_type' => 'application/json', 'delivery_mode' => 2]);

        $channel->basic_publish($message, $this->exchange, $routingKey);

        $channel->close();
        $connection->close();
    }
}
