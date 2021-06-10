<?php

namespace App\Controller\Admin;

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

#[Route('/admin/texte')]
class TexteController extends AbstractController
{
    #[Route('/', name: 'texte_index', methods: ['GET'])]
    public function index(TexteRepository $texteRepository): Response
    {
        $totalItems = $texteRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/texte?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/texte/index.html.twig', [
            'textes' => $texteRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new/{id}', name: 'texte_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, InstruRepository $instruRepository): Response
    {
        $instru = $instruRepository->find($id);
        $texte = new Texte();
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte->setUser($this->getUser());
            $texte->setInstru($instru);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($texte);
            $entityManager->flush();

            return $this->redirectToRoute('texte_index');
        }

        return $this->render('admin/texte/new.html.twig', [
            'texte' => $texte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'texte_show', methods: ['GET'])]
    public function show(Texte $texte): Response
    {
        return $this->render('admin/texte/show.html.twig', [
            'texte' => $texte,
        ]);
    }

    #[Route('/{id}/edit', name: 'texte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Texte $texte): Response
    {
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('texte_index');
        }

        return $this->render('admin/texte/edit.html.twig', [
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
