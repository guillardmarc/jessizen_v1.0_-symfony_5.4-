<?php

namespace App\TwigExtension;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ArticlesExtension extends AbstractExtension
{

    public function __construct(EntityManagerInterface $em, ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
    }

    public function getFunctions():array
    {
        return[
            new twigFunction('article',[$this,'getLastFiveArticles']),
            new twigFunction('article',[$this,'getThreebestRatedArticles']),
            new twigFunction('article',[$this,'getFiveMostViewedArticles'])
        ];
    }

    public function getLastFiveArticles()
    {
        return $this->articlesRepository->lastFiveArticlesPublied();
    }

    public function getThreeBestRatedArticlesPublied()
    {
        return $this->articlesRepository->threeBestRatedArticlesPublied();
    }

    public function getFiveMostViewedArticlesPublied()
    {
        return $this->articlesRepository->fiveMostViewedArticlesPublied();
    }
}