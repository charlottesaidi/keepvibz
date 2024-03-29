<?php

namespace App\Controller\Admin;

use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

#[Route('/admin/competence')]
class CompetenceController extends AbstractController
{
    #[Route('/', name: 'competence_index', methods: ['GET'])]
    public function index(CompetenceRepository $competenceRepository): Response
    {
        $totalItems = $competenceRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/annonce?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/competence/index.html.twig', [
            'competences' => $competenceRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'competence_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();

            $this->addFlash('success', 'Compétence créée avec succès');

            return $this->redirectToRoute('competence_index');
        }

        return $this->render('admin/competence/new.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'competence_show', methods: ['GET'])]
    public function show(Competence $competence): Response
    {
        return $this->render('admin/competence/show.html.twig', [
            'competence' => $competence,
        ]);
    }

    #[Route('/{id}/edit', name: 'competence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competence $competence): Response
    {
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competence->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Modification prise en compte');

            return $this->redirectToRoute('competence_index');
        }

        return $this->render('admin/competence/edit.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'competence_delete', methods: ['POST'])]
    public function delete(Request $request, Competence $competence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competence);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Suppression confirmée');

        return $this->redirectToRoute('competence_index');
    }
}
