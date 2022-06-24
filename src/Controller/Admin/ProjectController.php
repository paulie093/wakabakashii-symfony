<?php

namespace App\Controller\Admin;

use App\Entity\Project\Project;
use App\Form\Project\ProjectType;
use App\Repository\Project\ProjectRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project")
 */
class ProjectController extends AdminController
{
    private ProjectRepository $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/", name="app_admin_project_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project/index.html.twig', [
            'page_title' => 'Projektek listája',
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
            'page_title' => 'Új projekt létrehozása',
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('admin/project/show.html.twig', [
            'page_title' => 'Projekt adatok',
            'project' => $project,
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
            'page_title' => 'Projekt szerkesztése',
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
}
