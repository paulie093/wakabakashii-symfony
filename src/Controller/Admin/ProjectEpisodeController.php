<?php

namespace App\Controller\Admin;

use App\Entity\Project\Episode;
use App\Form\Project\EpisodeType;
use App\Repository\Project\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project-episode")
 */
class ProjectEpisodeController extends AdminController
{
    private EpisodeRepository $episodeRepository;

    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * @Route("/", name="app_admin_project_episode_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project_episode/index.html.twig', [
            'page_title' => 'Epizódlista',
            'episodes' => $this->episodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_project_episode_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->episodeRepository->add($episode, true);

            return $this->redirectToRoute('app_admin_project_episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_episode/new.html.twig', [
            'page_title' => 'Új epizód hozzáadása',
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_episode_show", methods={"GET"})
     */
    public function show(Episode $episode): Response
    {
        return $this->render('admin/project_episode/show.html.twig', [
            'page_title' => 'Epizód adatai',
            'episode' => $episode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_project_episode_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Episode $episode): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->episodeRepository->add($episode, true);

            return $this->redirectToRoute('app_admin_project_episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_episode/edit.html.twig', [
            'page_title' => 'Epizód szerkesztése',
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_episode_delete", methods={"POST"})
     */
    public function delete(Request $request, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $this->episodeRepository->remove($episode, true);
        }

        return $this->redirectToRoute('app_admin_project_episode_index', [], Response::HTTP_SEE_OTHER);
    }
}
