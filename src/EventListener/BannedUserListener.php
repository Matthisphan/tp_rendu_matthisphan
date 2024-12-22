<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class BannedUserListener
{
    private Security $security;
    private RouterInterface $router;

    public function __construct(Security $security, RouterInterface $router)
    {
        $this->security = $security;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();

        // Vérifie si l'utilisateur est connecté et possède le rôle "ROLE_BANNED"
        if ($user && in_array('ROLE_BANNED', $user->getRoles(), true)) {
            // Redirige vers une page spécifique
            $event->setResponse(new RedirectResponse($this->router->generate('banned_user')));
        }
    }
}