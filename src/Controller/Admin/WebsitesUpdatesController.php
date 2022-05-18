<?php

namespace App\Controller\Admin;

use App\Entity\WebsitesUpdates;
use App\Form\WebsitesUpdatesType;
use App\Repository\WebsitesUpdatesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route(name="app_websites_updates_")
 * @IsGranted("ROLE_ADMIN")
 */
class WebsitesUpdatesController extends AbstractController
{
    /**
     * @Route("/liste_des_mise_a_jour", name="index", methods={"GET"})
     */
    public function listWebsitesUpdates(WebsitesUpdatesRepository $websitesUpdatesRepository): Response
    {
        return $this->render('admin/websites_updates/index.html.twig', [
            'websites_updates' => $websitesUpdatesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/cree_mise_a_jour", name="new", methods={"GET", "POST"})
     */
    public function newWebsitesUpdates(Request $request, WebsitesUpdatesRepository $websitesUpdatesRepository): Response
    {
        $websitesUpdate = new WebsitesUpdates();
        $form = $this->createForm(WebsitesUpdatesType::class, $websitesUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $dateTime = new DateTime();
            $underVersion = $dateTime->format('ymd');

            $websitesUpdate->setCreatedAt($dateTime)
                           ->setModifiedAt($dateTime)
                           ->setAuthor($user)
                           ->setUnderVersion($underVersion);

            $websitesUpdatesRepository->add($websitesUpdate);
            return $this->redirectToRoute('app_websites_updates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/websites_updates/new.html.twig', [
            'websites_update' => $websitesUpdate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/mise_a_jour_ {id}", name="show", methods={"GET"})
     */
    public function showWebsitesUpdates(WebsitesUpdates $websitesUpdate): Response
    {
        return $this->render('admin/websites_updates/show.html.twig', [
            'websites_update' => $websitesUpdate,
        ]);
    }

    /**
     * @Route("/modification_mise_a_jour_{id}", name="edit", methods={"GET", "POST"})
     */
    public function editWebsitesUpdates(Request $request, WebsitesUpdates $websitesUpdate, WebsitesUpdatesRepository $websitesUpdatesRepository): Response
    {
        $form = $this->createForm(WebsitesUpdatesType::class, $websitesUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateTime = new DateTime();

            $websitesUpdate->setModifiedAt($dateTime);

            $websitesUpdatesRepository->add($websitesUpdate);
            return $this->redirectToRoute('app_websites_updates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/websites_updates/edit.html.twig', [
            'websites_update' => $websitesUpdate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/suppression_mise_a_jour_{id}", name="delete", methods={"POST"})
     */
    public function deletWebsitesUpdates(Request $request, WebsitesUpdates $websitesUpdate, WebsitesUpdatesRepository $websitesUpdatesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$websitesUpdate->getId(), $request->request->get('_token'))) {
            $websitesUpdatesRepository->remove($websitesUpdate);
        }

        return $this->redirectToRoute('app_websites_updates_index', [], Response::HTTP_SEE_OTHER);
    }
}
