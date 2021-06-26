<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Avatar;
use App\Form\UserProfileType;
use App\Form\AvatarType;
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
use Intervention\Image\ImageManager;
use Symfony\Component\HttpClient\HttpClient;

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
        $passwordErrors = [];
        $profileErrors = [];
        $form = $this->createForm(UserProfileType::class, $user);
        $changePasswordForm = $this->createForm(ChangeProfilePasswordType::class, $user);
        $avatarForm = $this->createForm(AvatarType::class, $avatar);

        if('POST' === $request->getMethod()) {
            if ($request->request->has('user_profile')) {
                $form->handleRequest($request);
            }
            if ($request->request->has('change_profile_password')) {
                $changePasswordForm->handleRequest($request);
            }
            if ($request->request->has('avatar')) {
                $avatarForm->handleRequest($request);
            }
        }

        if ($request->request->has('user_profile')) {
            if($form->isSubmitted() && $form->isValid()) {
                $user->setModifiedAt(new \dateTime());
                if($form->get('email')->getData() != null) {
                    $user->setEmail($form->get('email')->getData());
                }
                if($form->get('phoneNumber')->getData() != null) {
                    $user->setPhoneNumber($form->get('phoneNumber')->getData());
                }
                if($form->get('name')->getData() != null) {
                    $user->setName($form->get('name')->getData());
                }
                if($form->get('town')->getData() != null) {
                    $user->setTown($form->get('town')->getData());
                }
                if($form->get('bio')->getData() != null) {
                    $user->setBio($form->get('bio')->getData());
                }
                if($form->get('visible')->getData() != null) {
                    $user->setVisible($form->get('visible')->getData());
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Modification prise en compte');
            }
        }

        if ($request->request->has('change_profile_password')) {
            if ($changePasswordForm->isSubmitted()) {
                if($changePasswordForm->isValid()) {
                    $this->changePassword($changePasswordForm, $user, $this->passwordEncoder);
                } else {  
                    foreach ($changePasswordForm->getErrors(true, true) as $error) {
                        $passwordErrors[] = $error->getMessage();
                    }
                }
            }
        }
        if ($request->request->has('avatar')) {
            if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
                $this->changeAvatar($avatarForm, $user, $avatar, $this->folderGenerator);
            }
        }

        return $this->render('/profile/index.html.twig', [
            'profileForm' => $form->createView(),
            'passwordForm' => $changePasswordForm->createView(),
            'avatarForm' => $avatarForm->createView(),
            'textes' => $this->texteRepo->findUserTextes($user),
            'instrus' => $this->instruRepo->findUserInstrus($user),
            'toplines' => $this->toplineRepo->findUserToplines($user),
            'passwordErrors' => $passwordErrors,
            'profileErrors' => $profileErrors
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
            
            $user->setPassword(
                    $passwordEncoder->encodePassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Modification prise en compte');
        }
    }

    public function changeAvatar($form, $user, $avatar, $folderGenerator) {
        if($form->get('file')->getData() != null) {
            $manager = new ImageManager();
            $folderGenerator->generateForlderTripleIfAbsent('uploads', 'uploads/images', 'uploads/images/avatars');
            
            $file = $form->get('file')->getData();

            $fileName =  uniqid(). '.' .$file->guessExtension();

            try {
                $manager->make($file)->fit(500, 500)->save($this->getParameter('avatars_directory') . '/' . $fileName);
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }

            $entityManager = $this->getDoctrine()->getManager();

            if($user->getAvatar() != null) {
                $oldAvatar = $user->getAvatar();
                $entityManager->remove($oldAvatar);
            }

            $user->setAvatar($avatar);
            $avatar->setFile($fileName);
            
            $entityManager->flush();
            $this->addFlash('success', 'Modification prise en compte');
        }
    }
}
