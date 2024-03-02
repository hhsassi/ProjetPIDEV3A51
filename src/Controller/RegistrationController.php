<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\JWTService;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $mail,MailerInterface $mailer, JWTService $jwt): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
                
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $header = [ 
                'typ' => 'JWT',
                'alg' => 'HS256'

            ];

            $payload = [
                'user_id'=>$user->getId()
            ];
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
            
            //dd($token);



            $email = (new TemplatedEmail())
            ->from('no-reply@artemis.com')
            ->to($user->getEmail())
            ->subject('Verifier Votre Compte Artemis')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/register.html.twig')
            ->context([
                'user' => $user,
                'token' =>$token
            ]);

            $mailer->send($email);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            
        }

        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UserRepository $usersRepository, EntityManagerInterface $em): Response
    {
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            // On récupère le payload
            $payload = $jwt->getPayload($token);

            // On récupère le user du token
            $user = $usersRepository->find($payload['user_id']);

            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if($user && !$user->isIsVerified()){
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('user_profile');
            }
        }
        // Ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('user_profile');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail,MailerInterface $mailer, UserRepository $usersRepository): Response
    {
        $user = $this->getUser();

        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');    
        }

        if($user->IsisVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('user_profile');    
        }

        // On génère le JWT de l'utilisateur
        // On crée le Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        // On crée le Payload
        $payload = [
            'user_id' => $user->getId()
        ];

        // On génère le token
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        // On envoie un mail
        $email = (new TemplatedEmail())
            ->from('no-reply@artemis.com')
            ->to($user->getEmail())
            ->subject('Verifier Votre Compte Artemis')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/register.html.twig')
            ->context([
                'user' => $user,
                'token' =>$token
            ]);

            $mailer->send($email);

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('user_profile');
    }

    
}
