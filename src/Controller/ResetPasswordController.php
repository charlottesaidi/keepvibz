<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Controller\RegistrationController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use function PHPUnit\Framework\isNull;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    private $emailVerifier;
     /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer, UserRepository $ur): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form -> handleRequest($request);
        $error = '';
        if ($form->isSubmitted() && $form->isValid()) {
            // traiter la requête
            $email = $form -> get("email") -> getData();
            $user = $ur -> findOneBySomeField($email);
            if($user == Null){
               $error = 'Cette adresse mail n\'est pas enregistrée';
                
            }else{
                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@keepvibz.fr', 'KeepVibz Reset Password'))
                    ->to($user->getEmail())
                    ->subject('Modification du mot de passe')
                    ->htmlTemplate('reset_password/reset_password_email.html.twig');
                $mailer->send($email);

               return $this->redirectToRoute('app_check_email');            
            }
            
            // vérifier le mail => erreur ou succès


            // si succès => envoie email avec token => redirection, méthode suivante (checkEmail)
        }
        
        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     */
    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('reset_password/check_email.html.twig');
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset/{email}/{token}', name: 'app_reset_password')]
    public function reset(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // récupère le token, stock en session et retire de l'URL => sécurité
        // vérifier sa présence => sinon: erreur
        // => si oui: vérifier sa validité => sinon: erreur => redirection sur le formulaire de confirmation d'email

        // vérifier le token, autoriser l'utilisateur à changer son mot de passe.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();

            // vider la session une fois le mot de passe changé et redirection sur formulaire de connexion.
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
