<?php

namespace AppBundle;

use Uecode\Bundle\QPushBundle\Event\MessageEvent;

class MessageConsumer
{
    /**
     * @var EmailService
     */
    private $emailService;

    /**
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param MessageEvent $messageEvent
     * @throws \Exception
     */
    public function sendEmail(MessageEvent $messageEvent)
    {
        $body = $messageEvent->getMessage()->getBody();

        if (!isset($body['userId']) || !isset($body['emailType'])) {
            throw new \Exception('userId or emailType not set in message');
        }

        $userId = $body['userId'];
        $emailType = $body['emailType'];

        $this->emailService->sendEmailToUser($userId, $emailType);
    }
}
