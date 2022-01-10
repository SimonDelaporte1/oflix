<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $maintenanceEnabled;

    public function __construct(bool $maintenanceEnabled)
    {
        $this->maintenanceEnabled = $maintenanceEnabled;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the main request
            return;
        }

        // Y'a-t-il une maintenance ?
        if ($this->maintenanceEnabled === false) {
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
        $newHtml = preg_replace(
            // Qu'est-ce qu'on cherche ?
            '/<\/nav>/',
            // Par quoi on remplace ?
            '</nav><div class="alert alert-danger m-3">Maintenance prévue mardi 10 janvier à 17h00</div>',
            // Dans quelle chaine ?
            $content,
            1
        );
        $response->setContent($newHtml);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
