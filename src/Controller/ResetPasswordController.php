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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use function PHPUnit\Framework\isNull;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    private $emailVerifier;
     /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer, UserRepository $ur, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);
        $error = '';

        if ($form->isSubmitted() && $form->isValid()) {
            // traiter la requête
            $email = $form -> get("email") -> getData();
            $user = $ur -> findOneByEmail($email);
            if($user == Null){
               $error = 'Cette adresse mail n\'est pas enregistrée';
                
            }else{
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
    
                $url = $this->generateUrl('app_reset_password', array('token' => $token, 'email' => $email), UrlGeneratorInterface::ABSOLUTE_URL);

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@keepvibz.fr', 'KeepVibz Reset Password'))
                    ->to($user->getEmail())
                    ->subject('Modification du mot de passe')
                    ->htmlTemplate('reset_password/reset_password_email.html.twig')
                    ->context([
                        'user' => $user,
                        'url' => $url
                    ]);
                $mailer->send($email);

               return $this->redirectToRoute('app_check_email');            
            }
        }
        
        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * Confirme à l'utilisateur que sa requête est prise en compte.
     */
    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('reset_password/check_email.html.twig');
    }

    /**
     * Vérifie et valide l'url suivi par l'utilisateur dans l'email
     */
    #[Route('/reset/{token}/{email}', name: 'app_reset_password')]
    public function reset($token, $email, Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepo): Response
    {
        $user = $userRepo->findOneByEmail($email);

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if($user == null) {

            // 404, url invalide
        
        } else {
            if($form->isSubmitted() && $form->isValid()) {
                $encodedPassword = $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );

                $user->setPassword($encodedPassword);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Ton mot de passe est réinitialisé. Tu peux te connecter');

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
