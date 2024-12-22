<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;  // Ajoute l'importation de EntityManagerInterface
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'article_show')]
    public function show(
        $id,
        ArticleRepository $articleRepository,
        CommentRepository $commentRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer l'article
        $article = $articleRepository->find($id);

        if (!$article) {
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        // Récupérer les commentaires de cet article
        $comments = $commentRepository->findBy(['article' => $article]);

        // Créer un nouveau commentaire
        $comment = new Comment();

        // Lier l'article et l'utilisateur connecté au commentaire
        $comment->setArticle($article);
        $comment->setUser($this->getUser());

        // Créer le formulaire de commentaire
        $form = $this->createForm(CommentType::class, $comment, [
            'show_article_user' => false,  // Masquer les champs 'article' et 'user'
        ]);

        // Traiter le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le commentaire dans la base de données
            $entityManager->persist($comment);  // Utilisation de l'EntityManager injecté
            $entityManager->flush();  // Sauvegarde dans la base

            // Rediriger après l'ajout
            return $this->redirectToRoute('article_show', ['id' => $id]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}
