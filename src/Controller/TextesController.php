<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Form\TexteType;
use App\Entity\Instru;
use App\Repository\TexteRepository;
use App\Repository\InstruRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

#[Route('/textes')]
class TextesController extends AbstractController
{
    #[Route('/', name: 'textes')]
    public function index(TexteRepository $texteRepository): Response
    {
        $totalItems = $texteRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/textes?page=(:num)';
        $offset = 0;

        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->render('textes/index.html.twig', [
            'textes' => $texteRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'textes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InstruRepository $instruRepository): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $texte = new Texte();
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte->setUser($this->getUser());
            if($form->get('instru')->getData() != null) {
                $instru = $instruRepository->findOneByTitle($form->get('instru')->getData());
                $texte->setInstru($instru);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($texte);
            $entityManager->flush();

            return $this->redirectToRoute('textes');
        }

        return $this->render('textes/new.html.twig', [
            'texte' => $texte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'texte_show', methods: ['GET'])]
    public function show(Texte $texte): Response
    {
        return $this->render('textes/show.html.twig', [
            'texte' => $texte,
        ]);
    }

    #[Route('/{id}/edit', name: 'textes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Texte $texte): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('textes');
        }

        return $this->render('textes/edit.html.twig', [
            'texte' => $texte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'textes_delete', methods: ['POST'])]
    public function delete(Request $request, Texte $texte): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete'.$texte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($texte);
            $entityManager->flush();

            $this->addFlash('success', 'Votre texte a été supprimé');
        }

        return $this->redirectToRoute('profile');
    }
}
