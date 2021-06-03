<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Form\AvatarType;
use App\Repository\AvatarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avatar')]
class AvatarController extends AbstractController
{
    #[Route('/', name: 'avatar_index', methods: ['GET'])]
    public function index(AvatarRepository $avatarRepository): Response
    {
        return $this->render('avatar/index.html.twig', [
            'avatars' => $avatarRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'avatar_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avatar);
            $entityManager->flush();

            return $this->redirectToRoute('avatar_index');
        }

        return $this->render('avatar/new.html.twig', [
            'avatar' => $avatar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'avatar_show', methods: ['GET'])]
    public function show(Avatar $avatar): Response
    {
        return $this->render('avatar/show.html.twig', [
            'avatar' => $avatar,
        ]);
    }

    #[Route('/{id}/edit', name: 'avatar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avatar $avatar): Response
    {
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('avatar_index');
        }

        return $this->render('avatar/edit.html.twig', [
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
