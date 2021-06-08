<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Avatar;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    #[Route('/', name: 'user_profile', methods: ['GET', 'POST'])]
    public function index(Request $request,  UserPasswordEncoderInterface $passwordEncoder): Response
    {           
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $avatar = new Avatar();
        $oldPassword = $user->getPassword();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setModifiedAt(new \dateTime());

            if($form->get('newPassword')->getData() != null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('newPassword')->getData()
                    )
                );
            }
            // avatar
            if ($avatar->getFile() !== null) {
                $file = $form->get('avatar')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                dd($fileName);
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $avatar->setUser($user);
                $avatar->setFile($fileName);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->render('/profile/index.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
}
