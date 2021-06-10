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

            return $this->redirectToRoute('instru_index');
        }

        return $this->render('instrus/new.html.twig', [
            'instru' => $instru,
            'form' => $form->createView(),
        ]);
    }
}
