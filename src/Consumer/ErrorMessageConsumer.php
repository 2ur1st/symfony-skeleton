<?php

namespace App\Consumer;

use App\Command\MessageProducerCommand;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class ErrorMessageConsumer implements ConsumerInterface
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
        if ($message['type'] === MessageProducerCommand::MESSAGE_TYPE_ERROR) {
            echo "Handled error message: {$message['message']}";
        }
    }
}
