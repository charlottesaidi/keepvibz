<?php

namespace App\Controller;

use App\Form\InstruType;
use App\Entity\Instru;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instrus')]
class InstrusController extends AbstractController
{
    #[Route('/', name: 'instrus')]
    public function index(): Response
    {
        // requête paginateAll()
        return $this->render('instrus/index.html.twig');
    }

    #[Route('/new', name: 'instrus_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
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

            return $this->redirectToRoute('instrus');
        }

        return $this->render('instrus/new.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'instru_show', methods: ['GET'])]
    public function show(Instru $instru): Response
    {
        return $this->render('instrus/show.html.twig', [
            'instru' => $instru,
        ]);
    }

    #[Route('/{id}/edit', name: 'instrus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instru $instru): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
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

            return $this->redirectToRoute('instrus');
        }

        return $this->render('instrus/edit.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'instrus_delete', methods: ['POST'])]
    public function delete(Request $request, Instru $instru): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete'.$instru->getId(), $request->request->get('_token'))) {
            if($instru->getFile() != null) {
                $filename = 'uploads/instrus/' . $topline->getFile();
                unlink($filename);
            }
            if($instru->getImage() != null) {
                $imagename = 'uploads/images/instrus' . $topline->getFile();
                unlink($imagename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instru);
            $entityManager->flush();

            $this->addFlash('success', 'Votre morceau a été supprimé');
        }

        return $this->redirectToRoute('profile');
    }
}
