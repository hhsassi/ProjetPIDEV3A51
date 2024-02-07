<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GestionUserController extends AbstractController
{
    #[Route('/gestion/user', name: 'app_gestion_user')]
    public function index(UserRepository $userRepository,Request $request,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
      
            
        }
        $users=$userRepository->findAll();

        return $this->render('gestion_user/index.html.twig', [
            'users'=>$users,
            'addUserForm' => $form->createView(),

            
        ]);
    }



    #[Route('/gestion/user/edit/{id}', name: 'app_gestion_user_edit')]
    public function edit(UserRepository $userRepository,Request $request,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager,$id): Response
    {
        $user = $userRepository->find($id);

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->flush();
            return $this->redirectToRoute('app_gestion_user');
      
            
        }

        return $this->render('gestion_user/edit.html.twig', [
            'editUserForm' => $form->createView(),


            
        ]);
    }
    #[Route('/gestion/user/delete/{id}', name: 'app_gestion_user_delete')]
    public function delete(UserRepository $userRepository,EntityManagerInterface $entityManager,$id): Response
    {
        
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_gestion_user');


       
    }

    #[Route('/profile', name: 'user_profile')]
    public function profile(UserRepository $userRepository,Request $request,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager ): Response
    {
       $user=$userRepository->find($this->getUser()->getId());
       $form = $this->createForm(UserFormType::class, $user);
       $form->remove('roles');

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $user->setPassword(
               $userPasswordHasher->hashPassword(
                   $user,
                   $form->get('plainPassword')->getData()
               )
           );

           $entityManager->flush();
     
           
       }


        return $this->render('gestion_user/profil.html.twig',[
            'profileForm' => $form->createView(),
 
        ]);
    }
    
    #[Route('/profile/me/delete', name: 'delete_me')]
    public function delete_me(EntityManagerInterface $entityManager ,TokenStorageInterface $tokenStorage): Response
    {
        $user = $this->getUser();

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();
            $tokenStorage->setToken(null);
            
            return $this->redirectToRoute('app_home_page'); 
        }
    

    
    }
    
}
