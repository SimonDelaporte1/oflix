<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the main request
            return;
        }
        
        // Si URL du Profiler ou de la WDT, on sort
        // $request->getPathInfo() contient la route
        if (preg_match('/^\/(_profiler|_wdt)/', $event->getRequest()->getPathInfo())) {
            return;
        }

        // Requête XHR/Fetch ? (AJAX)
        if ($event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $response = $event->getResponse();
        $content = $response->getContent();
        $content = str_replace('</nav>','</nav><div class="alert alert-danger">Maintenance prévue mardi 10 janvier à 17h00</div>', $content);
        $response->setContent($content);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
