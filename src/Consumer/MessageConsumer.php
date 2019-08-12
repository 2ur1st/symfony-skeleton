<?php

namespace App\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class MessageConsumer implements ConsumerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $looger)
    {
        $this->logger = $looger;
    }

    public function execute(AMQPMessage $message)
    {
        $message = unserialize($message->getBody());
        echo "Handled message: {$message['message']}, type {$message['type']}";
    }
}
