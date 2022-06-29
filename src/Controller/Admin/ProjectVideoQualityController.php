<?php

namespace App\Controller\Admin;

use App\Entity\Project\ProjectVideoQuality;
use App\Form\Project\ProjectVideoQualityType;
use App\Repository\Project\ProjectVideoQualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/project-video-quality")
 */
class ProjectVideoQualityController extends AdminController
{
    private ProjectVideoQualityRepository $projectVideoQualityRepository;

    public function __construct(TranslatorInterface $translator, ProjectVideoQualityRepository $projectVideoQualityRepository)
    {
        parent::__construct($translator);
        $this->projectVideoQualityRepository = $projectVideoQualityRepository;
    }

    /**
     * @Route("/list", name="app_admin_project_video_quality_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project_video_quality/index.html.twig', [
            'page_title' => $this->translator->trans('title.project.video_quality.list', [], 'admin'),
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
            'page_title' => $this->translator->trans('title.project.video_quality.add', [], 'admin'),
            'project_video_quality' => $projectVideoQuality,
            'form' => $form,
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
            'page_title' => $this->translator->trans('title.project.video_quality.edit', [], 'admin') . " - " . $projectVideoQuality->getName(),
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
