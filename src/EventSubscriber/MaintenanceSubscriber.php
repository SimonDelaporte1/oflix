<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $content = $response->getContent();
        $content = str_replace('<body>','<body><div class="alert alert-danger">Maintenance prévue mardi 10 janvier à 17h00</div>', $content);
        $response->setContent($content);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
