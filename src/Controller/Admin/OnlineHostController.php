<?php

namespace App\Controller\Admin;

use App\Entity\Project\OnlineHost;
use App\Form\Project\OnlineHostType;
use App\Repository\Fansub\TeamRepository;
use App\Repository\Project\OnlineHostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/online/host")
 */
class OnlineHostController extends AdminController
{
    private OnlineHostRepository $onlineHostRepository;

    public function __construct(OnlineHostRepository $onlineHostRepository)
    {
        $this->onlineHostRepository = $onlineHostRepository;
    }

    /**
     * @Route("/", name="app_admin_online_host_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/online_host/index.html.twig', [
            'page_title' => 'Online szolgáltató lista',
            'online_hosts' => $this->onlineHostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_online_host_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $onlineHost = new OnlineHost();
        $form = $this->createForm(OnlineHostType::class, $onlineHost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->onlineHostRepository->add($onlineHost, true);

            return $this->redirectToRoute('app_admin_online_host_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/online_host/new.html.twig', [
            'page_title' => 'Új online szolgáltató hozzáadása',
            'online_host' => $onlineHost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_online_host_show", methods={"GET"})
     */
    public function show(OnlineHost $onlineHost): Response
    {
        return $this->render('admin/online_host/show.html.twig', [
            'page_title' => 'Online szolgáltató adatai',
            'online_host' => $onlineHost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_online_host_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OnlineHost $onlineHost): Response
    {
        $form = $this->createForm(OnlineHostType::class, $onlineHost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->onlineHostRepository->add($onlineHost, true);

            return $this->redirectToRoute('app_admin_online_host_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/online_host/edit.html.twig', [
            'page_title' => 'Online szolgáltató szerkesztése',
            'online_host' => $onlineHost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_online_host_delete", methods={"POST"})
     */
    public function delete(Request $request, OnlineHost $onlineHost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$onlineHost->getId(), $request->request->get('_token'))) {
            $this->onlineHostRepository->remove($onlineHost, true);
        }

        return $this->redirectToRoute('app_admin_online_host_index', [], Response::HTTP_SEE_OTHER);
    }
}
