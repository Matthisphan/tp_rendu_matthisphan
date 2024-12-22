<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\SecurityBundle\Security;

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

        if ($user) {
            // Vérifiez si l'utilisateur a le rôle ROLE_BANNED
            if (in_array('ROLE_BANNED', $user->getRoles(), true)) {
                // Redirection vers la page de bannissement
                $event->setResponse(new RedirectResponse($this->router->generate('banned_user')));
            }
        }
    }
}
