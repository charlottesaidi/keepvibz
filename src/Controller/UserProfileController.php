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
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, AvatarRepository $avatarRepo, FolderGenerator $folderGenerator): Response
    {           
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $avatar = new Avatar();
        $oldPassword = $user->getPassword();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user->setModifiedAt(new \dateTime());
            $this->changePassword($form, $user, $passwordEncoder);
            $this->changeAvatar($form, $folderGenerator, $user, $avatar);

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
            
        $this->addFlash('success', 'Ton compte est bien désactivé');

        return $this->redirectToRoute('app_logout');
    }

    public function changePassword($form, $user, $passwordEncoder) {
        if($form->get('newPassword')->getData() != null) {
            if($form->get('oldPassword')->getData() != null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('newPassword')->getData()
                    )
                );
                $this->addFlash('profile-success', 'Modification prise en compte');
            } else {
                $this->addFlash('error', 'Tu dois renseigner ton ancien mot de passe pour le modifier'); 
            }
        } 
    }

    public function changeAvatar($form, $folderGenerator, $user, $avatar) {
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
            $avatar->setUser($user);
            $avatar->setFile($fileName);
            $this->addFlash('profile-success', 'Modification prise en compte');
        }
    }
}
