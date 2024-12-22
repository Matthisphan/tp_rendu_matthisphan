<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, LanguageRepository $languageRepository): Response
    {
        // Récupérer toutes les catégories
        $categories = $categoryRepository->findAll();
        $languages = $languageRepository->findAll();

        // Rendu du template avec les catégories
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'languages' => $languages,
        ]);
    }
}
