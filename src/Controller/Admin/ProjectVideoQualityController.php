<?php

namespace App\Controller\Admin;

use App\Entity\Project\ProjectVideoQuality;
use App\Form\Project\ProjectVideoQualityType;
use App\Repository\Project\ProjectVideoQualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project-video-quality")
 */
class ProjectVideoQualityController extends AdminController
{
    private ProjectVideoQualityRepository $projectVideoQualityRepository;

    public function __construct(ProjectVideoQualityRepository $projectVideoQualityRepository)
    {
        $this->projectVideoQualityRepository = $projectVideoQualityRepository;
    }

    /**
     * @Route("/", name="app_admin_project_video_quality_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project_video_quality/index.html.twig', [
            'page_title' => 'Videóminőség lista',
            'project_video_qualities' => $this->projectVideoQualityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_project_video_quality_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $projectVideoQuality = new ProjectVideoQuality();
        $form = $this->createForm(ProjectVideoQualityType::class, $projectVideoQuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectVideoQualityRepository->add($projectVideoQuality, true);

            return $this->redirectToRoute('app_admin_project_video_quality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_video_quality/new.html.twig', [
            'page_title' => 'Új videóminőség hozzáadása',
            'project_video_quality' => $projectVideoQuality,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_video_quality_show", methods={"GET"})
     */
    public function show(ProjectVideoQuality $projectVideoQuality): Response
    {
        return $this->render('admin/project_video_quality/show.html.twig', [
            'page_title' => 'Videóminőség adatok',
            'project_video_quality' => $projectVideoQuality,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_project_video_quality_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProjectVideoQuality $projectVideoQuality): Response
    {
        $form = $this->createForm(ProjectVideoQualityType::class, $projectVideoQuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectVideoQualityRepository->add($projectVideoQuality, true);

            return $this->redirectToRoute('app_admin_project_video_quality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_video_quality/edit.html.twig', [
            'page_title' => 'Videóminőség szerkesztése',
            'project_video_quality' => $projectVideoQuality,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_video_quality_delete", methods={"POST"})
     */
    public function delete(Request $request, ProjectVideoQuality $projectVideoQuality): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectVideoQuality->getId(), $request->request->get('_token'))) {
            $this->projectVideoQualityRepository->remove($projectVideoQuality, true);
        }

        return $this->redirectToRoute('app_admin_project_video_quality_index', [], Response::HTTP_SEE_OTHER);
    }
}
