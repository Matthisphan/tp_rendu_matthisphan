<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content');  // Champ visible pour l'utilisateur

        // Vérifier si les champs 'article' et 'user' doivent être visibles
        if ($options['show_article_user']) {
            // Pour l'administrateur ou les cas où on veut voir ces champs
            $builder
                ->add('article', EntityType::class, [
                    'class' => Article::class,
                    'choice_label' => 'title',
                ])
                ->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                ]);
        } else {
            // Masquer ces champs pour les utilisateurs normaux
            $builder
                ->add('article', EntityType::class, [
                    'class' => Article::class,
                    'choice_label' => 'title',
                    'mapped' => false,  // Ne pas mapper ce champ à l'entité
                    'attr' => ['style' => 'display:none;']  // Masquer le champ via du CSS
                ])
                ->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'mapped' => false,  // Ne pas mapper ce champ à l'entité
                    'attr' => ['style' => 'display:none;']  // Masquer le champ via du CSS
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'show_article_user' => false,  // Option par défaut, masqué pour les utilisateurs normaux
        ]);
    }
}
