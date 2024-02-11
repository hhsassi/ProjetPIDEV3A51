<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PretController extends AbstractController
{
    #[Route('/pret', name: 'app_pret', methods:'GET')]
    public function index(PretRepository $pretRepository): Response
    {
     $pretList = $pretRepository->findAll();
    dump(count($pretList));

    return $this->render('pret/index.html.twig', ['pretList' => $pretList]);
    }

    #[Route('/pret/ajout', name: 'app_add_pret')]
    public function addPret(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pret = new Pret();
        
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
  

            $entityManager->persist($pret);
            $entityManager->flush();
            // do anything else you need here, like send an email
        }

        return $this->render('pret/index.html.twig');
    }
}
