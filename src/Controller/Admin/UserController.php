<?php

namespace App\Controller\Admin;

use App\Entity\User\User;
use App\Form\User\UserType;
use App\Repository\User\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/user")
 */
class UserController extends AdminController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        TranslatorInterface $translator,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct($translator);
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/", name="app_admin_user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'page_title' => $this->translator->trans('title.administration.users.list', [], 'admin'),
            'users' => $this->userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_user_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'page_title' => $this->translator->trans('title.administration.users.add', [], 'admin'),
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_user_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($this->passwordHasher->needsRehash($user)) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'page_title' => $this->translator->trans('title.administration.users.edit', [], 'admin') . " - " . $user->getUserIdentifier(),
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
