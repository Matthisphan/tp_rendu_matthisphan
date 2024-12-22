<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LanguageRepository;

class LanguageController extends AbstractController
{
    #[Route('/language', name: 'app_language')]
    public function index(LanguageRepository $languageRepository): Response
    {
        // Récupérer toutes les catégories
        $languages = $languageRepository->findAllLanguages();

        // Rendu du template avec les catégories
        return $this->render('category/index.html.twig', [
            'languages' => $languages,
        ]);
    }


    #[Route('/language/{id}', name: 'language_show')]
    public function show($id, LanguageRepository $languageRepository, ArticleRepository $articleRepository): Response
    {
        // Récupérer la catégorie
        $language = $languageRepository->find($id);

        if (!$language) {
            throw $this->createNotFoundException('La langue n\'existe pas');
        }

        // Récupérer les articles de cette catégorie
        $articles = $articleRepository->findBy(['language' => $language]);

        return $this->render('language/show.html.twig', [
            'language' => $language,
            'articles' => $articles,
        ]);
    }
}
