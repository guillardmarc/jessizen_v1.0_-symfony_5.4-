<?php

namespace App\TwigExtention;

use App\Repository\WebsitesRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WebsitesExtension extends AbstractExtension
{
    public function __construct(WebsitesRepository $websitesRepository)
    {
        $this->websitesRepository = $websitesRepository;
    }

    public function getFunctions()
    {
        return[
            new TwigFunction('website',[$this,'getWebsite'])
        ];
    }

    public function getWebsite()
    {
        return $this->websiteRepo->publicationByDate();
    }
}