<?php

namespace App\Controller\Admin;

use App\Entity\Project\ProjectStatus;
use App\Form\Project\ProjectStatusType;
use App\Repository\Project\ProjectStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/project-status")
 */
class ProjectStatusController extends AdminController
{
    private ProjectStatusRepository $projectStatusRepository;

    public function __construct(TranslatorInterface $translator, ProjectStatusRepository $projectStatusRepository)
    {
        parent::__construct($translator);
        $this->projectStatusRepository = $projectStatusRepository;
    }

    /**
     * @Route("/list", name="app_admin_project_status_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project_status/index.html.twig', [
            'page_title' => $this->translator->trans('title.project.status.list', [], 'admin'),
            'project_statuses' => $this->projectStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_project_status_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $projectStatus = new ProjectStatus();
        $form = $this->createForm(ProjectStatusType::class, $projectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectStatusRepository->add($projectStatus, true);

            return $this->redirectToRoute('app_admin_project_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_status/new.html.twig', [
            'page_title' => $this->translator->trans('title.project.status.add', [], 'admin'),
            'project_status' => $projectStatus,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_project_status_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProjectStatus $projectStatus): Response
    {
        $form = $this->createForm(ProjectStatusType::class, $projectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectStatusRepository->add($projectStatus, true);

            return $this->redirectToRoute('app_admin_project_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_status/edit.html.twig', [
            'page_title' => $this->translator->trans('title.project.status.edit', [], 'admin') . " - " . $projectStatus->getName(),
            'project_status' => $projectStatus,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_status_delete", methods={"POST"})
     */
    public function delete(Request $request, ProjectStatus $projectStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectStatus->getId(), $request->request->get('_token'))) {
            $this->projectStatusRepository->remove($projectStatus, true);
        }

        return $this->redirectToRoute('app_admin_project_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
