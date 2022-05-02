<?php

namespace App\Controller\User;

use App\Entity\Users;
use App\Entity\UsersLinks;
use App\Form\UserDeletType;
use App\Form\UserType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route(name="app_user_")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/ma_page", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function editUser(Users $user, Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $sluggerInterface): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idUser = $user->getId();
            
            /** Début du code à ajouter **/
            // Récupération de la valeur du champs "picture"
            $picture = $form->get('picture')->getData();
            
            if($picture) {
                // On récupère le nom de l'image
                $link = $user->getPictureProfilName();
                if ($link != "") {
                    // On supprime le fichier
                    unlink($this->getParameter('picture_users_directory')."/user_id".$idUser."/".$link);
                }

                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $newFilename = uniqid($safeFilename).'.'.$picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                    $this->getParameter('picture_users_directory').'/user_id'.$idUser,
                    $newFilename
                    );
                }
                catch (FileException $e) {
                // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // Sauvegarde du nom dans la base de donnée
                $user->setPictureProfilAlt($safeFilename)
                     ->setPictureProfilLink("uploads/users/user_id".$idUser."/".$newFilename)
                     ->setPictureProfilName($newFilename);
            }
            /** Fin du code à ajouter **/
            if ($form->get('link')->getData() != "") {
                if(preg_match("/facebook/i", $form->get('link')->getData())) {
                    $typeLink = "facebook";
                }
                elseif(preg_match("/youtube/i", $form->get('link')->getData())) {
                    $typeLink = "youtube";
                }
                
                $savelink = new UsersLinks();
                $savelink->setCreatedAt(new DateTime())
                         ->setType($typeLink)
                         ->setUrl($form->get('link')->getData());
                $user->addUsersLink($savelink);
            }

            $user->setModifiedAt(new DateTime());
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'formUser' => $form,
        ]);
    }

    /**
     * @Route("/downloaddata", name="downloaddata")
     */
    public function downloadDataUser(): Response
    {
        // Option pdf definied:
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Dompdf initialisation
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed'=>true
            ]
        ]);
        $dompdf->setHttpContext($context);

        // html generaled:
        $html = $this->renderView('user/data_download.html.twig');
        $dompdf->load_Html($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // File generaled:
        
        $fichier = 'user-data-'. $this->getUser()->getId() . '.pdf';
        $dompdf->stream($fichier, [
            'Attachement' => true
        ]);

        return new Response();
    }

    /**
     * @Route("/{id}/delet", name="delet", methods={"POST"})
     */
    public function deletUser(Users $user, EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $idUser = $user->getId();
            $dir = $this->getParameter('picture_users_directory').'/user_id'.$idUser;

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

            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();

        }
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/delect_picture/{id}", name="picture_delete", methods={"DELETE"})
     */
    public function deleteImage(Users $user, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // We check if the token is valid
        if($this->isCsrfTokenValid('delete'.$user->getId(), $data['_token'])){
            $idUser=$user->getId();
            // On récupère le nom de l'image
            $link = $user->getPictureProfilName();
            // On supprime le fichier
            unlink($this->getParameter('picture_users_directory')."/user_id".$idUser."/".$link);

            // On supprime l'entrée de la base
            $em=$this->getDoctrine()->getManager();
            $user->setpictureProfilAlt(Null)
                 ->setpictureProfilLink(Null)
                 ->setpictureProfilname(Null);
            $em->persist($user);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/delect_link/{id}", name="link_delete", methods={"DELETE"})
     */
    public function deleteLink(UsersLinks $userLink, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        
        //We check if the token is valid
        if($this->isCsrfTokenValid('delete'.$userLink->getId(), $data['_token'])){
            // On supprime l'entrée de la base
            $em=$this->getDoctrine()->getManager();
            $em->remove($userLink);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

}
