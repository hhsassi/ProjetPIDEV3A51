<?php

namespace App\Controller;
use App\Entity\Certification;
use App\Repository\CertificationRepository;
use App\Form\CertificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CertificationController extends AbstractController
{
    #[Route('/GestionCertification', name: 'app_certification')]
    public function index(CertificationRepository $certificationRepository): Response
    {
        return $this->render('certification/back-end/index.html.twig', [
            'certifications' => $certificationRepository->findAll(),
         ]);
    }
    #[Route('/certification', name: 'front_certification')]
    public function afficher(CertificationRepository $certificationRepository): Response
    {
        return $this->render('certification/front-end/index.html.twig', [
            'certifications' => $certificationRepository->findAll(),
         ]);
    }
    #[Route('/certification/show/{id}', name: 'show_front_certification')]
    public function Frontshow(int $id, EntityManagerInterface $entityManager): Response
{
    $certification = $entityManager->getRepository(Certification::class)->find($id);

    if (!$certification) {
        throw $this->createNotFoundException('No certification found for id '.$id);
    }

    return $this->render('certification/front-end/show.html.twig', [
        'certification' => $certification,
    ]);

} 

    #[Route('/GestionCertification/new', name: 'new_certification')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certification = new Certification();
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            
            $badgeFile = $form->get('badgeCertif')->getData();
            if ($badgeFile) {
                $originalFilename = pathinfo($badgeFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$badgeFile->guessExtension();

                try {
                    $badgeFile->move(
                        $this->getParameter('certification_directory'), 
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                }

               
                $certification->setBadgeCertif($newFilename);
            }
    
            $entityManager->persist($certification);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_certification', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('certification/back-end/new.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]); 
    } 

    #[Route('/GestionCertification/edit/{id}', name: 'edit_certification')]
public function edit(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(CertificationType::class, $certification);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $badgeFile */
        $badgeFile = $form->get('badgeCertif')->getData();
        if ($badgeFile) {
            $currentBadgePath = $certification->getBadgeCertif();
            if ($currentBadgePath) {
                $fullPath = $this->getParameter('certification_directory').'/'.$currentBadgePath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            $newFilename = uniqid().'.'.$badgeFile->guessExtension();
            try {
                $badgeFile->move(
                    $this->getParameter('certification_directory'), 
                    $newFilename
                );
                $certification->setBadgeCertif($newFilename);
            } catch (FileException $e) {
               
            }
        }

        $entityManager->persist($certification);
        $entityManager->flush();

        $this->addFlash('success', 'Certification mise à jour avec succès.');

        return $this->redirectToRoute('app_certification'); 
    }

    return $this->render('certification/back-end/edit.html.twig', [
        'certification' => $certification,
        'form' => $form->createView(),
    ]);
}

    #[Route('/GestionCertification/delete/{id}', name: 'delete_certification')]
public function delete(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$certification->getId(), $request->request->get('_token'))) {
        $badgePath = $this->getParameter('certification_directory') . '/' . $certification->getBadgeCertif();
        if (file_exists($badgePath)) {
            unlink($badgePath);
        }
        $entityManager->remove($certification);
        $entityManager->flush();
        $this->addFlash('success', 'Certification deleted successfully.');
    }

    return $this->redirectToRoute('app_certification');
}
#[Route('/GestionCertification/show/{id}', name: 'show_certification')]
public function show(int $id, EntityManagerInterface $entityManager): Response
{
    $certification = $entityManager->getRepository(Certification::class)->find($id);

    if (!$certification) {
        throw $this->createNotFoundException('No certification found for id '.$id);
    }

    return $this->render('certification/back-end/show.html.twig', [
        'certification' => $certification,
    ]);

} 


public function validateImage($image)
{
    $maxSize = 1024 * 1024; // 1MB en octets
    $allowedMimeTypes = ['image/png', 'image/jpeg'];

    if ($image->getSize() > $maxSize) {
        return 'The image cannot be larger than 1MB.';
    }

    if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
        return 'Please upload a valid PNG or JPG image.';
    }

    return true;    


}
}