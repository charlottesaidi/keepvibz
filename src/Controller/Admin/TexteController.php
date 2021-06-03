<?php

namespace App\Controller\Admin;

use App\Entity\Texte;
use App\Form\TexteType;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/texte')]
class TexteController extends AbstractController
{
    #[Route('/', name: 'texte_index', methods: ['GET'])]
    public function index(TexteRepository $texteRepository): Response
    {
        return $this->render('texte/index.html.twig', [
            'textes' => $texteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'texte_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $texte = new Texte();
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($texte);
            $entityManager->flush();

            return $this->redirectToRoute('texte_index');
        }

        return $this->render('texte/new.html.twig', [
            'texte' => $texte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'texte_show', methods: ['GET'])]
    public function show(Texte $texte): Response
    {
        return $this->render('texte/show.html.twig', [
            'texte' => $texte,
        ]);
    }

    #[Route('/{id}/edit', name: 'texte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Texte $texte): Response
    {
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('texte_index');
        }

        return $this->render('texte/edit.html.twig', [
            'texte' => $texte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'texte_delete', methods: ['POST'])]
    public function delete(Request $request, Texte $texte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$texte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($texte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('texte_index');
    }
}
