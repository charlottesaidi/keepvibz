<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\AdminContactFormType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use JasonGrimes\Paginator;

#[Route('/admin/contact')]
class ContactAdminController extends AbstractController
{
    #[Route('/', name: 'contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        $totalItems = $contactRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/contact?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contactRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/{id}', name: 'contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        if($contact->getUnread() == true) {
            $contact->setUnread(false);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/admin_response/{id}', name: 'admin_response', methods: ['POST'])]
    public function adminResponse(Request $request, Contact $contact, MailerInterface $mailer): Response
    {
        if(!empty($request->get('message'))) {
            $response = $request->get('message');
            $subject = $contact->getSubject();

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@keepvibz.fr', 'KeepVibz Reply'))
                ->to($contact->getEmail())
                ->subject('Re: '. $subject)
                ->context([
                    'reply' => $response,
                    'subject' => $subject
                ])
                ->htmlTemplate('admin/contact/reply_contact.html.twig');
            $mailer->send($email);

            $this->addFlash('success', 'Réponse envoyée');
        } else {
            $this->addFlash('error', 'La réponse ne peut pas être vide');
        }
        return $this->redirect('/admin/contact/'. $contact->getId());
    }

    #[Route('/{id}', name: 'contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }
}
