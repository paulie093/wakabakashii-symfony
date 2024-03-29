<?php

namespace App\Controller\Admin;

use App\Entity\Project\Episode;
use App\Entity\Project\Project;
use App\Form\Project\EpisodeType;
use App\Form\Project\ProjectType;
use App\Repository\Project\EpisodeRepository;
use App\Repository\Project\ProjectRepository;
use App\Service\FileUploader;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    private FileUploader $fileUploader;

    public function __construct(
        TranslatorInterface $translator,
        ProjectRepository $projectRepository,
        EpisodeRepository $episodeRepository,
        FileUploader $fileUploader
    ) {
        parent::__construct($translator);
        $this->projectRepository = $projectRepository;
        $this->episodeRepository = $episodeRepository;
        $this->fileUploader = $fileUploader;
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
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $coverImageFile */
            $coverImageFile = $form->get('coverImage')->getData();
            if ($coverImageFile)
            {
                $coverImageFileName = $this->fileUploader->upload($coverImageFile, $this->getParameter('projects_dir'), $project->getToken());
                $project->setCoverImage($coverImageFileName);
            }
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
     * @throws Exception
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $coverImageFile */
            $coverImageFile = $form->get('coverImage')->getData();
            if ($coverImageFile)
            {
                if ($project->getCoverImage()) {
                    unlink($this->getParameter('projects_dir') . "/" . $project->getCoverImage());
                }
                $coverImageFileName = $this->fileUploader->upload($coverImageFile, $this->getParameter('projects_dir'), $project->getToken());
                $project->setCoverImage($coverImageFileName);
            }
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
        return $this->render('admin/project_episode/index.html.twig', [
            'page_title' => $project->getTitle() . " - " . $this->translator->trans('title.project.episode.list', [], 'admin'),
            'project' => $project,
            'episodes' => $project->getEpisodes(),
        ]);
    }

    /**
     * @Route("/{id}/episodes/new", name="app_admin_project_episode_new", methods={"GET", "POST"})
     * @throws Exception
     */
    public function addProjectEpisode(Request $request, Project $project): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $episodeImageFile */
            $episodeImageFile = $form->get('episodeImage')->getData();
            if ($episodeImageFile)
            {
                $filename = $this->fileUploader->upload($episodeImageFile, $this->getParameter('episode_images_dir') . "/" . $project->getToken(), "ep" . $episode->getEpisodeNumber());
                $episode->setEpisodeImage($filename);
            }

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
     * @throws Exception
     */
    public function editProjectEpisode(Request $request, Project $project, int $episodeId): Response
    {
        $episode = $this->episodeRepository->find($episodeId);
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $episodeImageFile */
            $episodeImageFile = $form->get('episodeImage')->getData();
            if ($episodeImageFile)
            {
                if ($episode->getEpisodeImage()) {
                    unlink($this->getParameter('episode_images_dir') . "/" . $episode->getEpisodeImage());
                }
                $filename = $this->fileUploader->upload($episodeImageFile, $this->getParameter('episode_images_dir') . "/" . $project->getToken(), "ep" . $episode->getEpisodeNumber());
                $episode->setEpisodeImage($filename);
            }

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
    public function deleteProjectEpisode(Request $request, Project $project, int $episodeId): Response
    {
        $episode = $this->episodeRepository->find($episodeId);
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $this->episodeRepository->remove($episode, true);
        }

        return $this->redirectToRoute('app_admin_project_episode_index', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
    }
}
