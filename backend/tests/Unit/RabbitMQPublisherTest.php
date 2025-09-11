<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RabbitMQPublisher;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Mockery;

class RabbitMQPublisherTest extends TestCase
{
    public function test_publish_creates_connection_and_channel()
    {
        $this->markTestSkipped('RabbitMQ integration test requires actual connection');
    }

    public function test_publish_encodes_payload_as_json()
    {
        $this->markTestSkipped('RabbitMQ integration test requires actual connection');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
