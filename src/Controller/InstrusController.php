<?php

namespace App\Controller;

use App\Form\InstruType;
use App\Entity\Instru;
use App\Repository\InstruRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FolderGenerator;
use JasonGrimes\Paginator;
use Intervention\Image\ImageManager;

#[Route('/instrus')]
class InstrusController extends AbstractController
{
    #[Route('/', name: 'instrus')]
    public function index(InstruRepository $instruRepository): Response
    {
        $totalItems = $instruRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/instrus?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $this->render('instrus/index.html.twig', [
            'instrus' => $instruRepository->paginateAll($itemsPerPage, $offset),
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'instrus_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  FolderGenerator $folderGenerator): Response
    {
        $instru = new Instru();
        $form = $this->createForm(InstruType::class, $instru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instru->setUser($this->getUser());
            
            // fichier
            if ($instru->getFile() != null) {
                $folderGenerator->generateFolderSubIfAbsent('uploads', 'uploads/instrus');

                $file = $form->get('file')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('instrus_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $instru->setFile($fileName);
            }
            // image
            if ($instru->getImage() != null) {
                $manager = new ImageManager();
                $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/instrus');

                $file = $form->get('image')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $manager->make($file)->fit(500, 500)->save($this->getParameter('imagesInstrus_directory') . '/' . $fileName);
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $instru->setImage($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($instru);
            $entityManager->flush();

            $this->addFlash('instru-success', 'Instru uploadée avec succès');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('instrus/new.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'instru_show', methods: ['GET'])]
    public function show(Instru $instru): Response
    {
        return $this->render('instrus/show.html.twig', [
            'instru' => $instru,
        ]);
    }

    #[Route('/{id}/edit', name: 'instrus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instru $instru, FolderGenerator $folderGenerator): Response
    {
        $form = $this->createForm(InstruType::class, $instru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instru->setModifiedAt(new \dateTime());
            if ($form->isSubmitted() && $form->isValid()) {
                
                // fichier
                if ($instru->getFile() != null) {
                    $folderGenerator->generateFolderSubIfAbsent('uploads', 'uploads/instrus');

                    $file = $form->get('file')->getData();
                    $fileName =  uniqid(). '.' .$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('instrus_directory'), // Le dossier dans lequel le fichier va etre chargé
                            $fileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $instru->setFile($fileName);
                }
                // image
                if ($instru->getImage() != null) {
                    $manager = new ImageManager();
                    $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/instrus');

                    $file = $form->get('image')->getData();
                    $fileName =  uniqid(). '.' .$file->guessExtension();
                    try {
                        $manager->make($file)->fit(500, 500)->save($this->getParameter('imagesInstrus_directory') . '/' . $fileName);
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $instru->setImage($fileName);
                }
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('instru-success', 'Modification prise en compte');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('instrus/edit.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'instrus_delete', methods: ['POST'])]
    public function delete(Request $request, Instru $instru): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instru->getId(), $request->request->get('_token'))) {
            // if($instru->getFile() != null) {
            //     if(is_dir('uploads/images/instrus')) {
            //         $filename = 'uploads/instrus/' . $topline->getFile();
            //         unlink($filename);
            //     }
            // }
            // if($instru->getImage() != null) {
            //     if(is_dir('uploads/images/instrus')) {
            //     $imagename = 'uploads/images/instrus' . $topline->getFile();
            //     unlink($imagename);
            //     }
            // }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instru);
            $entityManager->flush();

            $this->addFlash('instru-success', 'Suppression confirmée');
        }

        return $this->redirectToRoute('user_profile');
    }
}
