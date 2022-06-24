<?php

namespace App\Controller;

use App\Repository\News\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    protected NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/news", name="app_news_list_all_news")
     */
    public function index(): Response
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'listaoldal',
            'news' => $this->newsRepository->findAll()
        ]);
    }

    /**
     * @Route("/news/{newsId}", name="app_news_list_one_news")
     */
    public function getNewsById(int $newsId): Response
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'hír: ' . $newsId,
            'newsId' => $newsId
        ]);
    }
}
