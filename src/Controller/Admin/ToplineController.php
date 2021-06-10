<?php

namespace App\Controller\Admin;

use App\Entity\Topline;
use App\Form\ToplineType;
use App\Repository\ToplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use JasonGrimes\Paginator;

#[Route('admin/topline')]
class ToplineController extends AbstractController
{
    #[Route('/', name: 'topline_index', methods: ['GET'])]
    public function index(ToplineRepository $toplineRepository): Response
    {
        $totalItems = $toplineRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/topline?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/topline/index.html.twig', [
            'toplines' => $toplineRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'topline_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $topline = new Topline();
        $form = $this->createForm(ToplineType::class, $topline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topline->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topline);
            $entityManager->flush();

            return $this->redirectToRoute('topline_index');
        }

        return $this->render('admin/topline/new.html.twig', [
            'topline' => $topline,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'topline_show', methods: ['GET'])]
    public function show(Topline $topline): Response
    {
        return $this->render('admin/topline/show.html.twig', [
            'topline' => $topline,
        ]);
    }

    #[Route('/{id}/edit', name: 'topline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Topline $topline): Response
    {
        $form = $this->createForm(ToplineType::class, $topline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topline->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topline_index');
        }

        return $this->render('admin/topline/edit.html.twig', [
            'topline' => $topline,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'topline_delete', methods: ['POST'])]
    public function delete(Request $request, Topline $topline): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topline->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topline_index');
    }
}
