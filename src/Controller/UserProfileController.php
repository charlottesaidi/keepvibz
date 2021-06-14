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

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    public $avatarRepo;
    public $texteRepo;
    public $instruRepo;
    public $toplineRepo;
    public $competenceRepo;
    public $editFunctions;

    public function __construct(ProfileEditFunctions $editFunctions, AvatarRepository $avatarRepo,TexteRepository $texteRepo, ToplineRepository $toplineRepo, InstruRepository $instruRepo, CompetenceRepository $competenceRepo) {
        $this->avatarRepo = $avatarRepo;
        $this->texteRepo = $texteRepo;
        $this->instruRepo = $instruRepo;
        $this->toplineRepo = $toplineRepo;
        $this->competenceRepo = $competenceRepo;
        $this->editFunctions = $editFunctions;
    }

    #[Route('/', name: 'user_profile', methods: ['GET', 'POST'])]
    public function index(Request $request, FolderGenerator $folderGenerator): Response
    {           
        $user = $this->getUser();

        $form = $this->createForm(UserProfileType::class, $user);
        $changePasswordForm = $this->createForm(ChangeProfilePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);

        $avatar = new Avatar();
        $oldPassword = $user->getPassword();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user->setModifiedAt(new \dateTime());
            $this->editFunctions->changeAvatar($form, $user, $avatar, $folderGenerator);
            
            if($form->get('email')->getData() != $user->getEmail()) {
                $user->setEmail($form->get('email')->getData());
                $this->editFunctions->flushUpdate();
            }
            if($form->get('phone')->getData() != $user->getPhone()) {
                $user->setPhone($form->get('phone')->getData());
                $this->editFunctions->flushUpdate();
            }
            if($form->get('name')->getData() != $user->getName()) {
                $user->setName($form->get('name')->getData());
                $this->editFunctions->flushUpdate();
            }
            if($form->get('town')->getData() != $user->getTown()) {
                $user->setTown($form->get('town')->getData());
                $this->editFunctions->flushUpdate();
            }
        }

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $this->editFunctions->changePassword($changePasswordForm, $user);
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
}
