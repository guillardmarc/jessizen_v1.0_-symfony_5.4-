<?php

namespace App\Controller\User;

use App\Entity\Categories;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/category_{slug}", name="view")
     */
    public function viewCategory(Categories $category, ArticlesRepository $articlesRepository): Response
    {
        $idCategory = $category->getId();
        
        return $this->render('user/category/view.html.twig', [
            'category' => $category,
            'lastFiveArticlesForCategory'=> $articlesRepository->lastFiveArticlesForCategory($idCategory),
            'threeBestRatedArticlesForCategory'=> $articlesRepository->threeBestRatedArticlesForCategory($idCategory),
            'fiveMostViewedArticlesForCategory'=> $articlesRepository->fiveMostViewedArticlesForCategory($idCategory),
            'articlesSortByDateForCategory'=> $articlesRepository->articlesSortByDateForCategory($idCategory),
        ]);
    }

    /**
     * @Route("/liste_categories_favories", name="list")
     */
    public function listFavoriesCategories(): Response
    {
        return $this->render('user/category/index.html.twig');
    }

    /**
     * @Route("/add_favory_category_{slug}", name="addfavory")
     */
    public function addFavoryCategories(Categories $category, EntityManagerInterface $entityManagerInterface): Response
    {
        $category->addFavory($this->getUser());
        $entityManagerInterface->persist($category);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_category_view',['slug' => $category->getSlug()]);
    }

    /**
     * @Route("/delet_favory_category_{slug}", name="deletfavory")
     */
    public function deletFavoryCategories(Categories $category, EntityManagerInterface $entityManagerInterface): Response
    {
        $category->removeFavory($this->getUser());
        $entityManagerInterface->persist($category);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_category_view',['slug' => $category->getSlug()]);
    }
}
