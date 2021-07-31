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
use App\Service\FolderGenerator;
use Intervention\Image\ImageManager;

#[Route('/admin/avatar')]
class AvatarController extends AbstractController
{
    #[Route('/', name: 'avatar_index', methods: ['GET'])]
    public function index(AvatarRepository $avatarRepository): Response
    {
        $totalItems = $avatarRepository->paginateCount();
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
    public function new(Request $request, FolderGenerator $folderGenerator): Response
    {
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar->setUser($this->getUser());
            if ($form->get('file')->getData() != null) {
                $manager = new ImageManager();
                
                $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/avatars');

                $file = $form->get('file')->getData();
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

            $this->addFlash('success', 'Avatar créé avec succès');

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
    public function edit(Request $request, Avatar $avatar, FolderGenerator $folderGenerator): Response
    {
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar->setModifiedAt(new \dateTime());
            if ($form->get('file')->getData() != null) {
                $manager = new ImageManager();
                
                $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/avatars');

                $file = $form->get('file')->getData();
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
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Modification prise en compte');

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
        $avatarUser = $avatar->getUser();
        if ($this->isCsrfTokenValid('delete'.$avatar->getId(), $request->request->get('_token'))) {
            $avatarUser->setAvatar(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avatar);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Suppression confirmée');

        return $this->redirectToRoute('avatar_index');
    }
}
