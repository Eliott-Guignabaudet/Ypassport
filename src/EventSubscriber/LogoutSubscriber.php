<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function onLogoutEvent($event): void
    {
        if (in_array('application/json', $event->getRequest()->getAcceptableContentTypes())) {
            $event->setResponse(new JsonResponse(['message' => 'You have been successfully logged out'], Response::HTTP_OK));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
