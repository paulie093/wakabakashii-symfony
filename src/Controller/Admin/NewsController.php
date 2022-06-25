<?php

namespace App\Controller\Admin;

use App\Entity\News\News;
use App\Form\News\NewsType;
use App\Repository\News\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/news")
 */
class NewsController extends AdminController
{
    protected NewsRepository $newsRepository;

    public function __construct(TranslatorInterface $translator, NewsRepository $newsRepository)
    {
        parent::__construct($translator);
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/", name="app_admin_news_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'page_title' => $this->translator->trans('title.news.list', [], 'admin'),
            'news' => $this->newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_news_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsRepository->add($news, true);

            return $this->redirectToRoute('app_admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news/new.html.twig', [
            'page_title' => $this->translator->trans('title.news.add', [], 'admin'),
            'news' => $news,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_news_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsRepository->add($news, true);

            return $this->redirectToRoute('app_admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news/edit.html.twig', [
            'page_title' => $this->translator->trans('title.news.edit', [], 'admin') . " - " . $news->getTitle(),
            'news' => $news,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_news_delete", methods={"POST"})
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $this->newsRepository->remove($news, true);
        }

        return $this->redirectToRoute('app_admin_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
