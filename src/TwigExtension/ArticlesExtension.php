<?php

namespace App\TwigExtention;

use App\Repository\ArticlesRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ArticlesExtension extends AbstractExtension
{
    public function __construct( ArticlesRepository $articlesRepository)
    {
        $this->articleRepository = $articlesRepository;
    }

    public function getFunctions()
    {
        return[
            new TwigFunction('articles',[$this,'getLastFiveArticlesPublied']),
            new TwigFunction('articles',[$this,'getThreeBestRatedArticlesPublied']),
            new TwigFunction('articles',[$this,'getFiveMostViewedArticlesPublied']),
        ];
    }

    public function getLastFiveArticlesPublied()
    {
        return $this->articleRepository->lastFiveArticlesPublied();
    }

    public function getThreeBestRatedArticlesPublied()
    {
        return $this->articleRepository->threeBestRatedArticlesPublied();
    }

    public function getFiveMostViewedArticlesPublied()
    {
        return $this->articleRepository->fiveMostViewedArticlesPublied();
    }
}