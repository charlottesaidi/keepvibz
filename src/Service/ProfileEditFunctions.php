<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\FolderGenerator;

class ProfileEditFunctions 
{
    private $passwordEncoder;

    private $folderGenerator;

    public function _construct(FolderGenerator $folderGenerator, UserPasswordEncoderInterface $passwordEncoder) 
    {
        $this->folderGenerator = $folderGenerator;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function changePassword($form, $user) {
        if($form->get('newPassword')->getData() != null) {
            $user->setPassword(
                $this->$passwordEncoder->encodePassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );
        }
    }

    public function changeAvatar($form, $user, $avatar) {
            $this->$folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/avatars');
            
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
?>