<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route(name="app_categories_")
 * @IsGranted("ROLE_ADMIN")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/liste_des_categories", name="index", methods={"GET"})
     */
    public function listCategories(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categoriesRepository->findBy([],['id'=>'DESC']),
        ]);
    }

    /**
     * @Route("/creer_categorie", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriesRepository $categoriesRepository, SluggerInterface $sluggerInterface): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $dateTime = new DateTime();
            $dateTimeFile = $dateTime->format('YmdHis');

            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('picture')->getData();
            
            if($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).$dateTimeFile.'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_categories_directory').'/',
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $category->setPictureAlt($safeFilename)
                         ->setPictureLink("uploads/categories/".$newFilename)
                         ->setPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            $slugTitle = $sluggerInterface->slug($form->get('title')->getData());

            $category->setCreatedAt($dateTime)
                     ->setModifiedAt($dateTime)
                     ->setAuthor($user)
                     ->setSlug($slugTitle);

            $categoriesRepository->add($category);
            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/categorie_{id}", name="show", methods={"GET"})
     */
    public function show(Categories $category): Response
    {
        return $this->render('admin/categories/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/modification_categories_{id}", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository, SluggerInterface $sluggerInterface): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $dateTime = new DateTime();
            $dateTimeFile = $dateTime->format('YmdHis');

            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('picture')->getData();
            
            if($picture) {
                // On récupère le nom de l'image
                $link = $category->getPictureName();
                if ($link != "") {
                    // On supprime le fichier
                    unlink($this->getParameter('picture_categories_directory')."/".$link);
                }

                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).$dateTimeFile.'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('picture_categories_directory').'/',
                        $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $category->setPictureAlt($safeFilename)
                         ->setPictureLink("uploads/categories/".$newFilename)
                         ->setPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            $slugTitle = $sluggerInterface->slug($form->get('title')->getData());

            $category->setModifiedAt($dateTime)
                     ->setAuthor($user)
                     ->setSlug($slugTitle);

            $categoriesRepository->add($category);
            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suppression_categories_{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            // On récupère le nom de l'image
            $link = $category->getPictureName();
            if ($link != "") {
                // On supprime le fichier
                unlink($this->getParameter('picture_categories_directory')."/".$link);
            }
            $categoriesRepository->remove($category);
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
