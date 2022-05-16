<?php

namespace App\TwigExtension;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension
{
    private $em;

    public function __construct(EntityManagerInterface $em,CategoriesRepository $categoriesRepository)
    {
        $this->em = $em;
        //$this->categoriesRepository = $categoriesRepository;
    }

    public function getFunctions()
    {
        return[
            new TwigFunction('categories',[$this,'getCategories'])
        ];
    }

    public function getCategories()
    {
        return $this->em->getRepository(Categories::class)->findAll();
        // return $this->categoriesRepository->categoryArticlesNotNull();
    }
}