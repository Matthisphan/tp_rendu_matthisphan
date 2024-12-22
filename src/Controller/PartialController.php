<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartialController extends AbstractController
{
    public function leftMenu(CategoryRepository $categoryRepository, LanguageRepository $languageRepository)
    {
        $categories = $categoryRepository->findAll();
        $languages = $languageRepository->findAll();

        return $this->render('parts/leftMenu.html.twig', [
            'categories' => $categories,
            'languages' => $languages,
        ]);
    }
}