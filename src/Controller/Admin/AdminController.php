<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/admin", name="app_admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'page_title' => $this->translator->trans('homepage', [], 'admin')
        ]);
    }
}