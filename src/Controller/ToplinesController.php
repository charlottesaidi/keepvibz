<?php

namespace App\Controller;

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
use App\Service\FolderGenerator;

#[Route('/toplines')]
class ToplinesController extends AbstractController
{
    #[Route('/', name: 'toplines', methods: ['GET'])]
    public function index(ToplineRepository $toplineRepository): Response
    {
        $totalItems = $toplineRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/toplines?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('toplines/index.html.twig', [
            'toplines' => $toplineRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'toplines_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FolderGenerator $folderGenerator): Response
    {
        $topline = new Topline();
        $form = $this->createForm(ToplineType::class, $topline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topline->setUser($this->getUser());
            
            // fichier
            if ($form->get('file')->getData() != null) {
                $folderGenerator->generateFolderSubIfAbsent('uploads', 'uploads/toplines');

                $file = $form->get('file')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('toplines_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $topline->setFile($fileName);
            }
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topline);
            $entityManager->flush();
            
            $this->addFlash('topline-success', 'Topline uploadée avec succès');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('toplines/new.html.twig', [
            'topline' => $topline,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'toplines_show', methods: ['GET'])]
    public function show(Topline $topline): Response
    {
        return $this->render('toplines/show.html.twig', [
            'topline' => $topline,
        ]);
    }

    #[Route('/{id}/edit', name: 'toplines_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Topline $topline, FolderGenerator $folderGenerator): Response
    {
        $form = $this->createForm(ToplineType::class, $topline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topline->setModifiedAt(new \dateTime());
            
            // fichier
            if ($topline->getFile() != null) {
                $folderGenerator->generateFolderSubIfAbsent('uploads', 'uploads/toplines');

                $file = $form->get('file')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('toplines_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $topline->setFile($fileName);
            }
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('topline-success', 'Modification prise en compte');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('toplines/edit.html.twig', [
            'topline' => $topline,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'toplines_delete', methods: ['POST'])]
    public function delete(Request $request, Topline $topline): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topline->getId(), $request->request->get('_token'))) {
            // if($topline->getFile() != null) {
            //     $filename = 'uploads/toplines/' . $topline->getFile();
            //     unlink($filename);
            // }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topline);
            $entityManager->flush();

            $this->addFlash('topline-success', 'Suppression confirmée');
        }

        return $this->redirectToRoute('user_profile');
    }
}
