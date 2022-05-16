<?php

namespace App\Controller\Author;

use App\Entity\Articles;
use App\Entity\ArticlesComments;
use App\Entity\ArticlesPictures;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route(name="app_articles_")
 * @IsGranted("ROLE_AUTHOR")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/liste_des_articles", name="list", methods={"GET"})
     */
    public function listArticle(ArticlesRepository $articlesRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('author/articles/index.html.twig', [
                'articles' => $articlesRepository->findBy([],['modifiedAt'=>'DESC']),
            ]);
        }
        else {
            return $this->render('author/articles/index_author.html.twig');
        }
        
    }

    /**
     * @Route("/ajouter_un_article", name="new", methods={"GET", "POST"})
     */
    public function newArticle(Request $request, ArticlesRepository $articlesRepository, SluggerInterface $sluggerInterface): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get('pictureTopLink')->getData() != Null) {
            $user = $this->getUser();
            $dateTime = new DateTime();
            $dateTimeFile = $dateTime->format('YmdHis');

            /**
             * Top image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('pictureTopLink')->getData();
            
            if($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_articles_directory').'/userid'.$user->getId().'article'.$dateTimeFile,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $article->setPictureTopAlt($safeFilename)
                        ->setPictureTopLink("uploads/articles/userid".$user->getId()."article".$dateTimeFile."/".$newFilename)
                        ->setPictureTopName($newFilename);
            }
            /** Fin du code à ajouter **/
            
            /**
             * Secondary image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $pictures = $form->get('pictureSecondaryLink')->getData();
            
            foreach($pictures as $picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                $picture->move(
                $this->getParameter('picture_articles_directory').'/userid'.$user->getId().'article'.$dateTimeFile,
                $newFilename
                );
                } catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $pictureSecondary = new ArticlesPictures();
                $pictureSecondary->setCreatedAt($dateTime)
                                 ->setAlt($safeFilename)
                                 ->setLink("uploads/articles/userid".$user->getId()."article".$dateTimeFile."/".$newFilename)
                                 ->setName($newFilename);
                
                $article->addArticlesPicture($pictureSecondary);
            }
            /** Fin du code à ajouter **/

            $slugTitle = $sluggerInterface->slug($form->get('title')->getData());

            $article->setCreatedAt($dateTime)
                    ->setModifiedAt($dateTime) 
                    ->setSlug($slugTitle)
                    ->setAuthor($user)
                    ->setNote('0')
                    ->setVoterNumber('0');

            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]); 
    }

    /**
     * @Route("/appercu_article_{slug}", name="show", methods={"GET"})
     */
    public function showArticle(Articles $article, Request $request): Response
    {
        return $this->render('author/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/modification_l_articles_{slug}", name="edit", methods={"GET", "POST"})
     */
    public function editArticle(Request $request, Articles $article, ArticlesRepository $articlesRepository, SluggerInterface $sluggerInterface): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $article->getAuthor()->getId();
            $dateTime = new DateTime();
            $createdAtArticle = $article->getCreatedAt()->format('YmdHis');

            /**
             * Top image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('pictureTopLink')->getData();
            
            if($picture) {
                // On récupère de nom de l'image
                $link = $article->getPictureTopName();
                if ($link != "") {
                    // On supprime le fichier
                    unlink($this->getParameter('picture_articles_directory').'/userid'.$userId.'article'.$createdAtArticle."/".$link);
                }
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_articles_directory').'/userid'.$userId.'article'.$createdAtArticle,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $article->setPictureTopAlt($safeFilename)
                        ->setPictureTopLink("uploads/articles/userid".$userId."article".$createdAtArticle."/".$newFilename)
                        ->setPictureTopName($newFilename);
            }
            /** Fin du code à ajouter **/
            
            /**
             * Secondary image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $pictures = $form->get('pictureSecondaryLink')->getData();
            
            foreach($pictures as $picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                $picture->move(
                $this->getParameter('picture_articles_directory').'/userid'.$userId.'article'.$createdAtArticle,
                $newFilename
                );
                } catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $pictureSecondary = new ArticlesPictures();
                $pictureSecondary->setCreatedAt($dateTime)
                                 ->setAlt($safeFilename)
                                 ->setLink("uploads/articles/userid".$userId."article".$createdAtArticle."/".$newFilename)
                                 ->setName($newFilename);
                
                $article->addArticlesPicture($pictureSecondary);
            }
            /** Fin du code à ajouter **/

            $slugTitle = $sluggerInterface->slug($form->get('title')->getData());

            $article->setModifiedAt($dateTime) 
                    ->setSlug($slugTitle);

            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delet_article", name="delet", methods={"POST"})
     */
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $idUser = $article->getAuthor()->getId();
            $createdAtArticle = $article->getCreatedAt()->format('YmdHis');
            $dir = $this->getParameter('picture_articles_directory').'/userid'.$idUser.'article'.$createdAtArticle;

            if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (filetype($dir."/".$object) == "dir") {
                            rmdir($dir."/".$object);
                        }
                        else {unlink($dir."/".$object);}
                    }
                }
                reset($objects);
                rmdir($dir);
            }

            $articlesRepository->remove($article);
        }

        return $this->redirectToRoute('app_articles_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delect_picture/{id}", name="picture_delete", methods={"DELETE"})
     */
    public function deleteLink(ArticlesPictures $articlePicture, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        
        //We check if the token is valid
        if($this->isCsrfTokenValid('delete'.$articlePicture->getId(), $data['_token'])){
            $idUser = $articlePicture->getArticle()->getAuthor()->getId();
            $createdAtArticle = $articlePicture->getArticle()->getCreatedAt()->format('YmdHis');
            // On récupère le nom de l'image
            $link = $articlePicture->getName();
            // On supprime le fichier
            unlink($this->getParameter('picture_articles_directory')."/userid".$idUser."article".$createdAtArticle."/".$link);

            // On supprime l'entrée de la base
            $em=$this->getDoctrine()->getManager();
            $em->remove($articlePicture);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    // /**
    //  * @Route("/delect_picture/{id}", name="picture_delete", methods={"DELETE"})
    //  */
    // public function deleteLink(ArticlesPictures $articlePicture, Request $request): Response
    // {
    //     $data = json_decode($request->getContent(), true);
        
    //     //We check if the token is valid
    //     if($this->isCsrfTokenValid('delete'.$articlePicture->getId(), $data['_token'])){
            
    //         // On supprime l'entrée de la base
    //         $em=$this->getDoctrine()->getManager();
    //         $em->remove($articlePicture);
    //         $em->flush();

    //         // On répond en json
    //         return new JsonResponse(['success' => 1]);
    //     }else{
    //         return new JsonResponse(['error' => 'Token Invalide'], 400);
    //     }
    // }
}
