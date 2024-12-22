<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response {
        // Rendu du template avec les données
        return $this->render('admin/index.html.twig', [
        ]);
    }
}