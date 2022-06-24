<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    private AuthenticationUtils $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function index(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_admin_index');
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUserName = $this->authenticationUtils->getLastUsername();

        return $this->render('admin/login/index.html.twig', [
            'page_title' => 'Bejelentkezés',
            'last_username' => $lastUserName,
            'error' => $error,
        ]);
    }
}
