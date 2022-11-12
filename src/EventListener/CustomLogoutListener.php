<?php

namespace App\EventListener;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class CustomLogoutListener
{
    /**
     * @Route("marchand/logout", name="marchand_logout", methods={"POST"})
     * @param LogoutEvent $logoutEvent
     * @return void
     */
    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $logoutEvent): void
    {
        $logoutEvent->setResponse(new RedirectResponse('admin/connexion', Response::HTTP_MOVED_PERMANENTLY));
    }
}
