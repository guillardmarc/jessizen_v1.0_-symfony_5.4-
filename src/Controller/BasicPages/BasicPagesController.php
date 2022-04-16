<?php

namespace App\Controller\BasicPages;

use App\Form\ContactUsType;
use App\Repository\WebsitesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_")
 */

class BasicPagesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('basic_pages/index.html.twig', []);
    }

    /**
     * @Route("/Nous_contacter", name="contact_us", methods={"GET", "POST"})
     */
    public function contactUs (Request $request, WebsitesRepository $websitesRepository, MailerInterface $mailerInterface)
    {
        $form = $this->createForm(ContactUsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get('city')->getData() == Null) {
            $rep = $websitesRepository->publicationByDatesingle();
            $emailTo = $rep->getOwner()->getEmail();
            
            $email = (new TemplatedEmail())
                ->from('no-reply@jessizen.fr')
                ->to($emailTo)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Vous avez reçus un message de contact sur le site (jessizen)')
                ->htmlTemplate('basic_pages/contact_us/_contact_us_email.html.twig')
                ->context([ 
                    'fromEmail' => $form->get('email')->getData(),
                    'name' => $form->get('name')->getData(),
                    'message' => $form->get('message')->getData()
                ]);

            $mailerInterface->send($email);

            $this->addFlash('success', 'Votre message à bien été envoyer!');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        elseif ($form->isSubmitted() && $form->isValid() && $form->get('city')->getData() != Null) {
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('basic_pages/contact_us/contact_us.html.twig', [
            'form' => $form,
        ]);
    }
}
