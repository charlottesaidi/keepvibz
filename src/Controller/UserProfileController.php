<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Avatar;
use App\Form\UserProfileType;
use App\Form\ChangeProfilePasswordType;
use App\Repository\UserRepository;
use App\Repository\AvatarRepository;
use App\Repository\TexteRepository;
use App\Repository\InstruRepository;
use App\Repository\ToplineRepository;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProfileEditFunctions;
use JasonGrimes\Paginator;
use App\Service\FolderGenerator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    public $avatarRepo;
    public $texteRepo;
    public $instruRepo;
    public $toplineRepo;
    public $competenceRepo;
    public $passwordEncoder;
    public $folderGenerator;

    public function __construct(AvatarRepository $avatarRepo,TexteRepository $texteRepo, ToplineRepository $toplineRepo, InstruRepository $instruRepo, CompetenceRepository $competenceRepo, FolderGenerator $folderGenerator, UserPasswordEncoderInterface $passwordEncoder) {
        $this->avatarRepo = $avatarRepo;
        $this->texteRepo = $texteRepo;
        $this->instruRepo = $instruRepo;
        $this->toplineRepo = $toplineRepo;
        $this->competenceRepo = $competenceRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->folderGenerator = $folderGenerator;
    }

    #[Route('/', name: 'user_profile', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {           
        $user = $this->getUser();
        $avatar = new Avatar();
        $oldPassword = $user->getPassword();

        $form = $this->createForm(UserProfileType::class, $user);
        $changePasswordForm = $this->createForm(ChangeProfilePasswordType::class, $user);

        if('POST' === $request->getMethod()) {
            if ($request->request->has('user_profile')) {
                $form->handleRequest($request);
            }
            if ($request->request->has('change_profile_password')) {
                $changePasswordForm->handleRequest($request);
            }
        } else {
            $form->handleRequest($request);
            $changePasswordForm->handleRequest($request);
        }
        if ($request->request->has('user_profile')) {
        if ($form->isSubmitted()) {
            $user->setModifiedAt(new \dateTime());
            $this->changeAvatar($form, $user, $avatar, $this->folderGenerator);
            
            if($form->get('email')->getData() != $user->getEmail()) {
                $user->setEmail($form->get('email')->getData());
            }
            if($form->get('phoneNumber')->getData() != $user->getPhoneNumber()) {
                $user->setPhoneNumber($form->get('phoneNumber')->getData());
            }
            if($form->get('name')->getData() != $user->getName()) {
                $user->setName($form->get('name')->getData());
            }
            if($form->get('town')->getData() != $user->getTown()) {
                $user->setTown($form->get('town')->getData());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Modification prise en compte');
        }
    }
    if ($request->request->has('change_profile_password')) {
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $this->changePassword($changePasswordForm, $user, $this->passwordEncoder);
        }
    }

        return $this->render('/profile/index.html.twig', [
            'profileForm' => $form->createView(),
            'passwordForm' => $changePasswordForm->createView(),
            'textes' => $this->texteRepo->findUserTextes($user),
            'instrus' => $this->instruRepo->findUserInstrus($user),
            'toplines' => $this->toplineRepo->findUserToplines($user),
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
            
        $this->addFlash('success', 'Ton compte a été supprimé');

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
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Modification prise en compte');
            } else {
                $this->addFlash('error', 'Tu dois renseigner ton mot de passe actuel pour le modifier');
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
