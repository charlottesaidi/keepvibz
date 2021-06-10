<?php

namespace App\Controller\Admin;

use App\Entity\Instru;
use App\Form\InstruType;
use App\Repository\InstruRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use JasonGrimes\Paginator;

#[Route('admin/instru')]
class InstruController extends AbstractController
{
    #[Route('/', name: 'instru_index', methods: ['GET'])]
    public function index(InstruRepository $instruRepository): Response
    {
        $totalItems = $instruRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/admin/instru?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('admin/instru/index.html.twig', [
            'instrus' => $instruRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'instru_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $instru = new Instru();
        $form = $this->createForm(InstruType::class, $instru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instru->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($instru);
            $entityManager->flush();

            return $this->redirectToRoute('instru_index');
        }

        return $this->render('admin/instru/new.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'instru_show', methods: ['GET'])]
    public function show(Instru $instru): Response
    {
        return $this->render('admin/instru/show.html.twig', [
            'instru' => $instru,
        ]);
    }

    #[Route('/{id}/edit', name: 'instru_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instru $instru): Response
    {
        $form = $this->createForm(InstruType::class, $instru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instru->setModifiedAt(new \dateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instru_index');
        }

        return $this->render('admin/instru/edit.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'instru_delete', methods: ['POST'])]
    public function delete(Request $request, Instru $instru): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instru->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instru);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instru_index');
    }
}
