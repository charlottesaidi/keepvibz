<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Avatar;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use JasonGrimes\Paginator;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $totalItems = count($userRepository->findAll());
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
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
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
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $avatar = new Avatar();
        $oldPassword = $user->getPassword();

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setModifiedAt(new \dateTime());
            // password
            if($form->get('password') == null) {
                $user->setPassword($oldPassword);
            } else {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            // avatar
            if ($avatar->getFile() !== null) {
                $file = $form->get('file')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
            
            $avatar->setUser($this->getUser());
            $avatar->setFile($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
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

        return $this->redirectToRoute('user_index');
    }
}
