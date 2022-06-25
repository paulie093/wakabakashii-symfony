<?php

namespace App\Controller\Admin;

use App\Entity\Project\Episode;
use App\Entity\Project\Project;
use App\Form\Project\EpisodeType;
use App\Form\Project\ProjectType;
use App\Repository\Project\EpisodeRepository;
use App\Repository\Project\ProjectRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/project")
 */
class ProjectController extends AdminController
{
    private ProjectRepository $projectRepository;
    private EpisodeRepository $episodeRepository;

    public function __construct(
        TranslatorInterface $translator,
        ProjectRepository $projectRepository,
        EpisodeRepository $episodeRepository
    ) {
        parent::__construct($translator);
        $this->projectRepository = $projectRepository;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * @Route("/list", name="app_admin_project_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project/index.html.twig', [
            'page_title' => $this->translator->trans('title.project.list', [], 'admin'),
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_project_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->add($project, true);

            return $this->redirectToRoute('app_admin_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/new.html.twig', [
            'page_title' => $this->translator->trans('title.project.add', [], 'admin'),
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_project_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUpdatedAt(new DateTimeImmutable());
            $this->projectRepository->add($project, true);

            return $this->redirectToRoute('app_admin_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/edit.html.twig', [
            'page_title' => $this->translator->trans('title.project.edit', [], 'admin') . " - " . $project->getTitle(),
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $this->projectRepository->remove($project, true);
        }

        return $this->redirectToRoute('app_admin_project_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/episodes", name="app_admin_project_episode_index", methods={"GET"})
     */
    public function listEpisodes(Project $project): Response
    {
        $projectEpisodes = $this->episodeRepository->findByProject($project);

        return $this->render('admin/project_episode/index.html.twig', [
            'page_title' => $project->getTitle() . " - " . $this->translator->trans('title.project.episode.list', [], 'admin'),
            'project' => $project,
            'episodes' => $projectEpisodes,
        ]);
    }

    /**
     * @Route("/{id}/episodes/new", name="app_admin_project_episode_new", methods={"GET", "POST"})
     */
    public function addProjectEpisode(Request $request, Project $project): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $episode->setProject($project);
            $this->episodeRepository->add($episode, true);

            return $this->redirectToRoute('app_admin_project_episode_index', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_episode/new.html.twig', [
            'page_title' => $project->getTitle() . " - " . $this->translator->trans('title.project.episode.add', [], 'admin'),
            'project' => $project,
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/episodes/{episodeId}/edit", name="app_admin_project_episode_edit", methods={"GET", "POST"})
     */
    public function editProjectEpisode(Request $request, Project $project, Episode $episode): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->episodeRepository->add($episode, true);

            return $this->redirectToRoute('app_admin_project_episode_index', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        $episodeNumber = "EP" . str_pad($episode->getEpisodeNumber(), 2, '0', STR_PAD_LEFT);
        $pageTitle = $project->getTitle() . " - " . $this->translator->trans('title.project.episode.edit', [], 'admin') . " - {$episodeNumber}: {$episode->getTitle()}";

        return $this->renderForm('admin/project_episode/edit.html.twig', [
            'page_title' => $pageTitle,
            'project' => $project,
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/episodes/{episodeId}", name="app_admin_project_episode_delete", methods={"POST"})
     */
    public function deleteProjectEpisode(Request $request, Project $project, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $this->episodeRepository->remove($episode, true);
        }

        return $this->redirectToRoute('app_admin_project_episode_index', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
    }
}
