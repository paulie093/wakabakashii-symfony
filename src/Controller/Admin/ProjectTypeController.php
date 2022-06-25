<?php

namespace App\Controller\Admin;

use App\Entity\Project\ProjectType;
use App\Form\Project\ProjectTypeType;
use App\Repository\Project\ProjectTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/project-type")
 */
class ProjectTypeController extends AdminController
{
    private ProjectTypeRepository $projectTypeRepository;

    public function __construct(TranslatorInterface $translator, ProjectTypeRepository $projectTypeRepository)
    {
        parent::__construct($translator);
        $this->projectTypeRepository = $projectTypeRepository;
    }

    /**
     * @Route("/", name="app_admin_project_type_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project_type/index.html.twig', [
            'page_title' => $this->translator->trans('title.project.type.list', [], 'admin'),
            'project_types' => $this->projectTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_project_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $projectType = new ProjectType();
        $form = $this->createForm(ProjectTypeType::class, $projectType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectTypeRepository->add($projectType, true);

            return $this->redirectToRoute('app_admin_project_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_type/new.html.twig', [
            'page_title' => $this->translator->trans('title.project.type.add', [], 'admin'),
            'project_type' => $projectType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_project_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProjectType $projectType): Response
    {
        $form = $this->createForm(ProjectTypeType::class, $projectType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectTypeRepository->add($projectType, true);

            return $this->redirectToRoute('app_admin_project_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project_type/edit.html.twig', [
            'page_title' => $this->translator->trans('title.project.type.edit', [], 'admin') . " - " . $projectType->getName(),
            'project_type' => $projectType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_type_delete", methods={"POST"})
     */
    public function delete(Request $request, ProjectType $projectType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectType->getId(), $request->request->get('_token'))) {
            $this->projectTypeRepository->remove($projectType, true);
        }

        return $this->redirectToRoute('app_admin_project_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
