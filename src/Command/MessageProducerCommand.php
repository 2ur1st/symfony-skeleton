<?php

namespace App\Command;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MessageProducerCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:message:create';

    /**
     * @var ProducerInterface
     */
    protected $producer;

    /**
     * @Assert\Choice(choices=MessageProducerCommand::MESSAGE_TYPE_ALLOWED, message="Choose a valid message type.")
     */
    protected $messageType;

    /**
     * @Assert\NotBlank
     */
    protected $message;

    public const MESSAGE_TYPE_SUCCESS = 'success';
    public const MESSAGE_TYPE_ERROR = 'error';
    public const MESSAGE_TYPE_ALLOWED = [
        self::MESSAGE_TYPE_SUCCESS,
        self::MESSAGE_TYPE_ERROR,
    ];

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption('message', 'm', InputOption::VALUE_REQUIRED, 'Hello world!')
            ->addOption('type', 't', InputOption::VALUE_OPTIONAL, 'Type of message')
            ->setDescription('Put the message to queue');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->message = $input->getOption('message');
        $this->messageType = $input->getOption('type');
        $this->validate();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $body = ['message' => $this->message, 'type' => $this->messageType];
        $this->producer->publish(serialize($body));
    }

    /**
     * @throws InvalidOptionException
     */
    private function validate(): void
    {
        $validator = $this->getContainer()->get('validator');
        $violations = $validator->validate($this);
        if ($violations->count()) {
            throw new InvalidOptionException((string) $violations);
        }
    }
}