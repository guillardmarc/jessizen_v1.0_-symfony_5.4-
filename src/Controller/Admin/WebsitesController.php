<?php

namespace App\Controller\Admin;

use App\Entity\Websites;
use App\Form\WebsitesType;
use App\Repository\WebsitesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route(name="app_websites_")
 * @IsGranted("ROLE_ADMIN")
 */
class WebsitesController extends AbstractController
{
    /**
     * @Route("/informations_site_web", name="index", methods={"GET"})
     */
    public function listWebsites(WebsitesRepository $websitesRepository): Response
    {
        return $this->render('admin/websites/index.html.twig', [
            'websites' => $websitesRepository->findBy([], ['id'=>'DESC']),
        ]);
    }

    /**
     * @Route("/creer_information_website", name="new", methods={"GET", "POST"})
     */
    public function newWebsitesUpdates(Request $request, WebsitesRepository $websitesRepository, SluggerInterface $sluggerInterface): Response
    {
        $website = new Websites();
        $form = $this->createForm(WebsitesType::class, $website);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $dateTime = new DateTime();
            $dateTimeFile = $dateTime->format('YmdHis');

            /**
             * Logo image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('logoPicture')->getData();
            
            if($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_websites_directory').'/userid'.$user->getId().'website'.$dateTimeFile,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $website->setLogoPictureAlt($safeFilename)
                        ->setLogoPictureLink("uploads/websites/userid".$user->getId()."website".$dateTimeFile."/".$newFilename)
                        ->setLogoPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            /**
             * Presentation image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('presentationPicture')->getData();
            
            if($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_websites_directory').'/userid'.$user->getId().'website'.$dateTimeFile,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $website->setPresentationPictureAlt($safeFilename)
                        ->setPresentationPictureLink("uploads/websites/userid".$user->getId()."website".$dateTimeFile."/".$newFilename)
                        ->setPresentationPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            $website->setCreatedAt($dateTime)
                    ->setModifiedAt($dateTime)
                    ->setAuthor($user);

            $websitesRepository->add($website);
            return $this->redirectToRoute('app_websites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/websites/new.html.twig', [
            'website' => $website,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/info_website_{id}", name="show", methods={"GET"})
     */
    public function showWebsitesUpdates(Websites $website): Response
    {
        return $this->render('admin/websites/show.html.twig', [
            'website' => $website,
        ]);
    }

    /**
     * @Route("/modification_info_website_{id}", name="edit", methods={"GET", "POST"})
     */
    public function editWebsitesUpdates(Request $request, Websites $website, WebsitesRepository $websitesRepository, SluggerInterface $sluggerInterface): Response
    {
        $form = $this->createForm(WebsitesType::class, $website);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $website->getAuthor();
            $dateTime = new DateTime();
            $dateTimeFile = $website->getCreatedAt()->format('YmdHis');

            /**
             * Logo image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('logoPicture')->getData();
            
            if($picture) {
                // On récupère le nom de l'image
                $link = $website->getLogoPictureName();
                if ($link != "") {
                    // On supprime le fichier
                    unlink($this->getParameter('picture_websites_directory')."/userid".$user->getId()."website".$dateTimeFile."/".$link);
                }

                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_websites_directory').'/userid'.$user->getId().'website'.$dateTimeFile,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $website->setLogoPictureAlt($safeFilename)
                        ->setLogoPictureLink("uploads/websites/userid".$user->getId()."website".$dateTimeFile."/".$newFilename)
                        ->setLogoPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            /**
             * Presentation image processing
             */
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('presentationPicture')->getData();
            
            if($picture) {
                // On récupère le nom de l'image
                $link = $website->getPresentationPictureName();
                if ($link != "") {
                    // On supprime le fichier
                    unlink($this->getParameter('picture_websites_directory')."/userid".$user->getId()."website".$dateTimeFile."/".$link);
                }

                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_websites_directory').'/userid'.$user->getId().'website'.$dateTimeFile.'/',
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $website->setPresentationPictureAlt($safeFilename)
                        ->setPresentationPictureLink("uploads/websites/userid".$user->getId()."website".$dateTimeFile."/".$newFilename)
                        ->setPresentationPictureName($newFilename);
            }
            /** Fin du code à ajouter **/

            $website->setModifiedAt($dateTime)
                    ->setAuthor($user);
            
            $websitesRepository->add($website);
            return $this->redirectToRoute('app_websites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/websites/edit.html.twig', [
            'website' => $website,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suppression_info_website_{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Websites $website, WebsitesRepository $websitesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$website->getId(), $request->request->get('_token'))) {
            $idUser = $website->getAuthor()->getId();
            $dateTimeFile = $website->getCreatedAt()->format('YmdHis');
            $dir = $this->getParameter('picture_websites_directory').'/userid'.$idUser.'website'.$dateTimeFile;

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

            $websitesRepository->remove($website);
        }

        return $this->redirectToRoute('app_websites_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delect_picture_logo/{id}", name="picture_logo_delete", methods={"DELETE"})
     */
    public function deleteImageLogo(Websites $website, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // We check if the token is valid
        if($this->isCsrfTokenValid('delete'.$website->getId(), $data['_token'])){
            $user=$website->getAuthor();
            $dateTimeFile = $website->getCreatedAt()->format('YmdHis');

            // On récupère le nom de l'image
            $link = $website->getLogoPictureName();
            // On supprime le fichier
            unlink($this->getParameter('picture_websites_directory')."/userid".$user->getId()."website".$dateTimeFile."/".$link);

            // On supprime l'entrée de la base
            $em=$this->getDoctrine()->getManager();
            $website->setLogoPictureAlt(Null)
                    ->setLogoPictureLink(Null)
                    ->setLogoPictureName(Null);
            $em->persist($website);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/delect_picture_presentation/{id}", name="picture_presentation_delete", methods={"DELETE"})
     */
    public function deleteImagePresentation(Websites $website, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // We check if the token is valid
        if($this->isCsrfTokenValid('delete'.$website->getId(), $data['_token'])){
            $user=$website->getAuthor();
            $dateTimeFile = $website->getCreatedAt()->format('YmdHis');

            // On récupère le nom de l'image
            $link = $website->getPresentationPictureName();
            // On supprime le fichier
            unlink($this->getParameter('picture_websites_directory')."/userid".$user->getId()."website".$dateTimeFile."/".$link);

            // On supprime l'entrée de la base
            $em=$this->getDoctrine()->getManager();
            $website->setPresentationPictureAlt('NULL')
                    ->setPresentationPictureLink('NULL')
                    ->setPresentationPictureName('NULL');
            $em->persist($website);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
