<?php

declare(strict_types=1);

namespace App\Web\Http\Login;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

#[
    Route(
        path: '/login',
        name: 'login',
    ),
]
final readonly class Login
{
    public function __construct(
        private AuthenticationUtils $authenticationUtils,
        private Environment $twig,
    ) {
    }

    public function __invoke(): Response
    {
        $username = $this->authenticationUtils->getLastUsername();
        $error = $this->authenticationUtils->getLastAuthenticationError();

        return new Response(
            $this->twig->render(
                'login.html.twig',
                [
                    'username' => $username,
                    'error' => $error,
                ]
            )
        );
    }
}
