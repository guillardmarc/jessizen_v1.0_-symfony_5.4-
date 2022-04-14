<?php

namespace App\TwigExtension;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return[
            new TwigFunction('categories',[$this,'getCategories'])
        ];
    }

    public function getCategories()
    {
        return $this->em->getRepository(Categories::class)->findAll([],['name'=>'ASC']);
    }
}