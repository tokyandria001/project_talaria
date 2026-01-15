<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SessionTimeoutSubscriber implements EventSubscriberInterface
{
    private RouterInterface $router;
    private int $timeout;

    public function __construct(
        RouterInterface $router,
        ParameterBagInterface $params
    ) {
        $this->router = $router;
        $this->timeout = $params->get('session_timeout');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        if (!$session || !$session->has('user')) {
            return;
        }

        $now = time();
        $lastActivity = $session->get('last_activity', $now);

        if (($now - $lastActivity) > $this->timeout) {
            $session->invalidate();

            $event->setResponse(
                new RedirectResponse($this->router->generate('app_login'))
            );
            return;
        }

        // Mise à jour de l'activité
        $session->set('last_activity', $now);
    }
}
