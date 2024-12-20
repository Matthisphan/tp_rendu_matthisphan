<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private const MAX_USERS = 10;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Créer des catégories
        $categories = $this->createCategories($manager, $faker);

        // Créer des langues
        $languages = $this->createLanguages($manager, $faker);

        // Créer des utilisateurs
        $users = $this->createUsers($manager, $faker);

        // Créer des articles
        $articles = $this->createArticles($manager, $faker, $users, $categories, $languages);

        // Créer des commentaires
        $this->createComments($manager, $faker, $articles, $users);

        $manager->flush();
    }

    private function createCategories(ObjectManager $manager, $faker): array
    {
        $categories = [];
        $categoryNames = ['Jsuis abonnée à Masdak', 'La graille', 'Le politiquement incorrect'];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name)
                ->setLabel($name);
            $categories[] = $category;
            $manager->persist($category);
        }

        return $categories;
    }

    private function createLanguages(ObjectManager $manager, $faker): array
    {
        $languages = [];
        $languageData = [
            ['code' => 'fr', 'name' => 'Français'],
            ['code' => 'en', 'name' => 'Anglais'],
            ['code' => 'es', 'name' => 'Espagnol'],
            ['code' => 'de', 'name' => 'Allemand'],
            ['code' => 'it', 'name' => 'Italien']
        ];

        foreach ($languageData as $data) {
            $language = new Language();
            $language->setCode($data['code'])
                ->setName($data['name']);
            $languages[] = $language;
            $manager->persist($language);
        }

        return $languages;
    }

    private function createUsers(ObjectManager $manager, $faker): array
    {
        $users = [];

        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $users[] = $user;
            $manager->persist($user);
        }

        // Ajouter un utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'adminpassword');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Ajouter un utilisateur banni
        $banned = new User();
        $banned->setEmail('banned@banned.com')
            ->setRoles(['ROLE_BANNED']);
        $hashedPassword = $this->passwordHasher->hashPassword($banned, 'bannedpassword');
        $banned->setPassword($hashedPassword);
        $manager->persist($banned);

        return $users;
    }

    private function createArticles(ObjectManager $manager, $faker, $users, $categories, $languages): array
    {
        $articles = [];

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence)
                ->setContent($faker->paragraph)
                ->setCreatedAt(new \DateTimeImmutable())  // DateTimeImmutable
                ->setUpdatedAt(new \DateTimeImmutable())  // DateTimeImmutable
                ->setUser($users[array_rand($users)])   // Utilisation de setUser
                ->setCategory($categories[array_rand($categories)]) // Utilisation de setCategory
                ->setLanguage($languages[array_rand($languages)]);  // Utilisation de setLanguage

            $articles[] = $article;
            $manager->persist($article);
        }

        return $articles;
    }

    private function createComments(ObjectManager $manager, $faker, $articles, $users): void
    {
        for ($i = 0; $i < 30; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->paragraph)
                ->setArticle($articles[array_rand($articles)])  // Lien avec un article
                ->setUser($users[array_rand($users)]);  // Lien avec un utilisateur

            $manager->persist($comment);
        }
    }
}
