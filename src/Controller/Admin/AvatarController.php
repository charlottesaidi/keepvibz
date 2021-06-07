<?php

namespace App\Controller\Admin;

use App\Entity\Avatar;
use App\Form\AvatarType;
use App\Repository\AvatarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use JasonGrimes\Paginator;

#[Route('/admin/avatar')]
class AvatarController extends AbstractController
{
    #[Route('/', name: 'avatar_index', methods: ['GET'])]
    public function index(AvatarRepository $avatarRepository): Response
    {
        $totalItems = count($avatarRepository->findAll());
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/avatar?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->render('admin/avatar/index.html.twig', [
            'avatars' => $avatarRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'avatar_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar->setUser($this->getUser());
            if ($avatar->getFile() !== null) {
                $file = $form->get('picture')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // Le dossier dans le quel le fichier va etre charger
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

            $avatar->setFile($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avatar);
            $entityManager->flush();

            return $this->redirectToRoute('avatar_index');
        }

        return $this->render('admin/avatar/new.html.twig', [
            'avatar' => $avatar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'avatar_show', methods: ['GET'])]
    public function show(Avatar $avatar): Response
    {
        return $this->render('admin/avatar/show.html.twig', [
            'avatar' => $avatar,
        ]);
    }

    #[Route('/{id}/edit', name: 'avatar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avatar $avatar): Response
    {
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('avatar_index');
        }

        return $this->render('admin/avatar/edit.html.twig', [
            'avatar' => $avatar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'avatar_delete', methods: ['POST'])]
    public function delete(Request $request, Avatar $avatar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avatar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avatar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('avatar_index');
    }
}
