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
            
            // fichier
            if ($instru->getFile() != null) {
                $directory = 'uploads';
                $subdirectory = 'uploads/instrus';

                if(!is_dir($directory)) {
                    mkdir($directory);
                    if(!is_dir($subdirectory)) {
                        mkdir($subdirectory);
                    }
                }
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
                $directory = 'uploads';
                $subdirectory = 'uploads/images';
                $imageDirectory = 'uploads/images/instrus';

                if(!is_dir($directory)) {
                    mkdir($directory);
                    if(!is_dir($subdirectory)) {
                        mkdir($subdirectory);
                        if(!is_dir($imageDirectory)) {
                            mkdir($imageDirectory);
                        }
                    }
                }
                $file = $form->get('image')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('imagesInstrus_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $instru->setImage($fileName);
            }
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
            if ($form->isSubmitted() && $form->isValid()) {
                
                // fichier
                if ($instru->getFile() != null) {
                    $directory = 'uploads';
                    $subdirectory = 'uploads/instrus';

                    if(!is_dir($directory)) {
                        mkdir($directory);
                        if(!is_dir($subdirectory)) {
                            mkdir($subdirectory);
                        }
                    }
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
                if ($instru->getFile() != null) {
                    $directory = 'uploads';
                    $subdirectory = 'uploads/images';
                    $imageDirectory = 'uploads/images/instrus';

                    if(!is_dir($directory)) {
                        mkdir($directory);
                        if(!is_dir($subdirectory)) {
                            mkdir($subdirectory);
                            if(!is_dir($imageDirectory)) {
                                mkdir($imageDirectory);
                            }
                        }
                    }
                    $file = $form->get('image')->getData();
                    $fileName =  uniqid(). '.' .$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('imagesInstrus_directory'), // Le dossier dans lequel le fichier va etre chargé
                            $fileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $instru->setImage($fileName);
                }
            }
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
            if($instru->getFile() != null) {
                $filename = 'uploads/instrus/' . $instru->getFile();
                unlink($filename);
            }
            if($instru->getImage() != null) {
                $imagename = 'uploads/images/instrus' . $instru->getFile();
                unlink($imagename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instru);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instru_index');
    }
}
