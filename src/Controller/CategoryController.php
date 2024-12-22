<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Récupérer toutes les catégories
        $categories = $categoryRepository->findAllCategories();

        // Rendu du template avec les catégories
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'category_show')]
    public function show($id, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        // Récupérer la catégorie
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Récupérer les articles de cette catégorie
        $articles = $articleRepository->findBy(['category' => $category]);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
