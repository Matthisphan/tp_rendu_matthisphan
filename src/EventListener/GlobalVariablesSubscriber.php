<?php

namespace App\EventListener;

use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class GlobalVariablesSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $categoryRepository;
    private $languageRepository;

    public function __construct(Environment $twig, CategoryRepository $categoryRepository, LanguageRepository $languageRepository)
    {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->languageRepository = $languageRepository;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $categories = $this->categoryRepository->findAll();
        $languages = $this->languageRepository->findAll();

        $this->twig->addGlobal('categories', $categories);
        $this->twig->addGlobal('languages', $languages);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}