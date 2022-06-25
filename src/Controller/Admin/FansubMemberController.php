<?php

namespace App\Controller\Admin;

use App\Entity\Fansub\Member;
use App\Form\Fansub\MemberType;
use App\Repository\Fansub\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/fansub-member")
 */
class FansubMemberController extends AdminController
{
    private MemberRepository $memberRepository;

    public function __construct(TranslatorInterface $translator, MemberRepository $memberRepository)
    {
        parent::__construct($translator);
        $this->memberRepository = $memberRepository;
    }

    /**
     * @Route("/", name="app_admin_fansub_member_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/fansub_member/index.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.member.list', [], 'admin'),
            'members' => $this->memberRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_fansub_member_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->memberRepository->add($member, true);

            return $this->redirectToRoute('app_admin_fansub_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fansub_member/new.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.member.add', [], 'admin'),
            'member' => $member,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_fansub_member_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Member $member): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->memberRepository->add($member, true);

            return $this->redirectToRoute('app_admin_fansub_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fansub_member/edit.html.twig', [
            'page_title' => $this->translator->trans('title.fansub.member.edit', [], 'admin') . " - " . $member->getNickname(),
            'member' => $member,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_fansub_member_delete", methods={"POST"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $this->memberRepository->remove($member, true);
        }

        return $this->redirectToRoute('app_admin_fansub_member_index', [], Response::HTTP_SEE_OTHER);
    }
}
