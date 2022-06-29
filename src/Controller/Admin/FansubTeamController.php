<?php

namespace App\Controller\Admin;

use App\Entity\Fansub\Team;
use App\Form\Fansub\TeamType;
use App\Repository\Fansub\MemberRepository;
use App\Repository\Fansub\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/fansub-team")
 */
class FansubTeamController extends AdminController
{
    private TeamRepository $teamRepository;

    public function __construct(TranslatorInterface $translator, TeamRepository $teamRepository)
    {
        parent::__construct($translator);
        $this->teamRepository = $teamRepository;
    }

    /**
     * @Route("/list", name="app_admin_fansub_team_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/fansub_team/index.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.team.list', [], 'admin'),
            'teams' => $this->teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_fansub_team_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teamRepository->add($team, true);

            return $this->redirectToRoute('app_admin_fansub_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fansub_team/new.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.team.add', [], 'admin'),
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_fansub_team_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teamRepository->add($team, true);

            return $this->redirectToRoute('app_admin_fansub_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fansub_team/edit.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.team.edit', [], 'admin') . " - " . $team->getName(),
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_fansub_team_delete", methods={"POST"})
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $this->teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_admin_fansub_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
