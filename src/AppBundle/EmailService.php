<?php

namespace AppBundle;

use Psr\Log\LoggerInterface;

class EmailService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $userId
     * @param $emailType
     */
    public function sendEmailToUser($userId, $emailType)
    {
        sleep(3); // to simulate an intensive process, maybe generating image attachments

        $this->logger->info(sprintf('sent %s to user %d', $emailType, $userId));

        // ...
    }
}
