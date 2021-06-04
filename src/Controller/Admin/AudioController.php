<?php

namespace App\Controller\Admin;

use App\Entity\Audio;
use App\Form\AudioType;
use App\Repository\AudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/audio')]
class AudioController extends AbstractController
{
    #[Route('/', name: 'audio_index', methods: ['GET'])]
    public function index(AudioRepository $audioRepository): Response
    {
        return $this->render('audio/index.html.twig', [
            'audios' => $audioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'audio_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $audio = new Audio();
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($audio);
            $entityManager->flush();

            return $this->redirectToRoute('audio_index');
        }

        return $this->render('audio/new.html.twig', [
            'audio' => $audio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'audio_show', methods: ['GET'])]
    public function show(Audio $audio): Response
    {
        return $this->render('audio/show.html.twig', [
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

        return $this->render('audio/edit.html.twig', [
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
