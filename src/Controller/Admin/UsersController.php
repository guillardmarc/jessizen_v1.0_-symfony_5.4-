<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route(name="app_users_")
 * @IsGranted("ROLE_ADMIN")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/liste_des_utilisateurs", name="index", methods={"GET"})
     */
    public function listUser(UsersRepository $usersRepository): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $usersRepository->findBy([], ['id'=>'DESC']),
        ]);
    }

    /**
     * @Route("/utilisateur_{id}", name="show", methods={"GET"})
     */
    public function showUsers(Users $user): Response
    {
        return $this->render('admin/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/modification_utilisateur_{id}", name="edit", methods={"GET", "POST"})
     */
    public function editUsers(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user);
            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suppression_utilisateur_{id}", name="delete", methods={"POST"})
     */
    public function deleteUsers(Request $request, Users $user, UsersRepository $usersRepository): Response
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
           
            $usersRepository->remove($user);
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
