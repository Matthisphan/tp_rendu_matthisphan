<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSuccessListener
{
    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onLogout(LogoutEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        if ($session) {
            $session->getFlashBag()->add('success', 'Vous avez été déconnecté avec succès.');
        }

        $event->setResponse(new RedirectResponse($this->router->generate('app_login')));
    }
}