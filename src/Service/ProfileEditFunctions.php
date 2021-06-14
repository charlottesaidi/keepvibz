<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileEditFunctions
{
    public $passwordEncoder;
    public $abstractController;

    public function _construct(UserPasswordEncoderInterface $passwordEncoder, AbstractController $abstractController) 
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->abstractController = $abstractController;
    }

    public function changePassword($form, $user) {
        if($form->get('newPassword')->getData() != null) {
            if($form->get('oldPassword')->getData() != null) {
            $user->setPassword(
                    $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->abstractController->addFlash('success', 'Modification prise en compte');
            } else {
                $this->abstractController->addFlash('error', 'Tu dois renseigner ton mot de passe actuel pour le modifier');
            }
        } 
    }

    public function changeAvatar($form, $user, $avatar, $folderGenerator) {
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
        }
    }
}
?>