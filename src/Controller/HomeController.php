<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, LanguageRepository $languageRepository, ArticleRepository $articleRepository): Response {
        // Récupérer toutes les catégories, les langues, et les articles triés par date de mise à jour
        $categories = $categoryRepository->findAll();
        $languages = $languageRepository->findAll();
        $articles = $articleRepository->findAllOrderByUpdatedAtDesc();

        // Rendu du template avec les données
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'languages' => $languages,
            'articles' => $articles,
        ]);
    }
}
