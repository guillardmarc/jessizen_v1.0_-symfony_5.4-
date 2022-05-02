<?php

namespace App\Controller\User;

use App\Entity\Articles;
use App\Form\NoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route(name="app_article_")
*/

class ArticleController extends AbstractController
{
    /**
     * @Route("/article_{slug}", name="view")
     */
    public function viewArticle(Articles $article, EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $form = $this->createForm(NoteType::class, $article);
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $noteForm = $form->get('note')->getData();
            if (is_numeric($noteForm)) {
                $newNote = ($article->getNote() + $noteForm)/($article->getVoterNumber()+1);
                $article->setNote($newNote)
                        ->setVoterNumber($article->getVoterNumber()+1);
                $entityManagerInterface->persist($article);
                $entityManagerInterface->flush();

                $this->addFlash('success', 'Vote note a bien été pris en compte');
                return $this->render('user/article/view.html.twig', [
                    'article' => $article,
                    'noteForm'=> $form->createView(),
                ]);
            }
        }
        else {
            $newView = $article->getViewNumber() +1;
            $article->setViewNumber($newView);
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
        }

        return $this->render('user/article/view.html.twig', [
            'article' => $article,
            'noteForm'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_articles_favories", name="list")
     */
    public function listFavoriesArticles(): Response
    {
        return $this->render('user/article/index.html.twig');
    }

    /**
     * @Route("/add_favory_article_{slug}", name="addfavory")
     */
    public function addFavoryArticle(Articles $article, EntityManagerInterface $entityManagerInterface): Response
    {
        $newView = $article->getViewNumber() -1;
        $article->setViewNumber($newView);
        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();
        
        $article->addFavory($this->getUser());
        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_article_view',['slug' => $article->getSlug()]);
    }

    /**
     * @Route("/delet_favory_article_{slug}", name="deletfavory")
     */
    public function deletFavoryArticle(Articles $article, EntityManagerInterface $entityManagerInterface): Response
    {
        $newView = $article->getViewNumber() -1;
        $article->setViewNumber($newView);
        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();

        $article->removeFavory($this->getUser());
        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_article_view',['slug' => $article->getSlug()]);
    }
}
