<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\AdminEditUserType;
use App\Entity\Avatar;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use JasonGrimes\Paginator;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $totalItems = $userRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/user?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@keepvibz.fr', 'KeepVibz Registration'))
                ->to($user->getEmail())
                ->subject('Création de ton compte')
                ->htmlTemplate('admin/user/account_created_email.html.twig');
            $mailer->send($email);

            $this->addFlash('success', 'Utilisateur enregistré avec succès. En attente de confirmation');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $editForm = $this->createForm(AdminEditUserType::class, $user);
        $editForm->handleRequest($request);
        $avatar = new Avatar();
        $oldPassword = $user->getPassword();

        if ($editForm->isSubmitted()) {
            if($editForm->get('actif')->getData() == false) {
                $user->setActif(false);

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@keepvibz.fr', 'Banishment notice'))
                    ->to($user->getEmail())
                    ->subject('Tu as été banni(e)')
                    ->htmlTemplate('admin/user/banishment_notice_email.html.twig');
                $mailer->send($email);
            } else {
                $user->setModifiedAt(new \dateTime());
                if($editForm->get('roles')->getData() != null) {
                    $user->addRole($editForm->get('roles')->getData());
                }
                $this->getDoctrine()->getManager()->flush();
            }

            $this->addFlash('success', 'Modification prise en compte');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'editForm' => $editForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Suppression confirmée');

        return $this->redirectToRoute('user_index');
    }
}
