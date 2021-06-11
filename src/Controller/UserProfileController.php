<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Avatar;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use App\Repository\AvatarRepository;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\FolderGenerator;

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    #[Route('/', name: 'user_profile', methods: ['GET', 'POST'])]
    public function index(Request $request,  UserPasswordEncoderInterface $passwordEncoder, AvatarRepository $avatarRepo, FolderGenerator $folderGenerator): Response
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
            if($form->get('avatar')->getData() != null) {
                $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/avatars');
                
                $file = $form->get('avatar')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('avatars_directory'), // Le dossier dans lequel le fichier va etre chargé
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                if($user->getAvatar() != null) {
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->remove($user->getAvatar());
                // $entityManager->flush();
                }
                $avatar->setUser($user);
                $avatar->setFile($fileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('/profile/index.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'auth_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
