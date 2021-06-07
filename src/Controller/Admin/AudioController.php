<?php

namespace App\Controller\Admin;

use App\Entity\Audio;
use App\Form\AudioType;
use App\Repository\AudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

#[Route('/admin/audio')]
class AudioController extends AbstractController
{
    #[Route('/', name: 'audio_index', methods: ['GET'])]
    public function index(AudioRepository $audioRepository): Response
    {
        $totalItems = count($audioRepository->findAll());
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/audio?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->render('admin/audio/index.html.twig', [
            'audios' => $audioRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'audio_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $audio = new Audio();
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $audio->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($audio);
            $entityManager->flush();

            return $this->redirectToRoute('audio_index');
        }

        return $this->render('admin/audio/new.html.twig', [
            'audio' => $audio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'audio_show', methods: ['GET'])]
    public function show(Audio $audio): Response
    {
        return $this->render('admin/audio/show.html.twig', [
            'audio' => $audio,
        ]);
    }

    #[Route('/{id}/edit', name: 'audio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Audio $audio): Response
    {
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $audio->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('audio_index');
        }

        return $this->render('admin/audio/edit.html.twig', [
            'audio' => $audio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'audio_delete', methods: ['POST'])]
    public function delete(Request $request, Audio $audio): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($audio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('audio_index');
    }
}
