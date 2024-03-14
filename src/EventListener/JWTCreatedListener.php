<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use App\Entity\User;
use Psr\Log\LoggerInterface;

class JWTCreatedListener
{
    private $user;
    private $userId;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userId = $user->getId();
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $payload['id'] = $this->userId;
        $event->setData($payload);
    }
}
