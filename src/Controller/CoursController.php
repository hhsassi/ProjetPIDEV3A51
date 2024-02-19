<?php

namespace App\Controller;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CoursController extends AbstractController
{
    #[Route('/GestionCours', name: 'app_cours')]
    public function index(CoursRepository $coursRepository ): Response
    {
        return $this->render('Cours/back-end/index.html.twig', [
            'cours' => $coursRepository->findAll(),
         ]);
    }
    #[Route('/GestionCours/new', name: 'new_cours')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData(); // Assuming 'file' is the name of your FileType field in the form
    
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    
                try {
                    $file->move(
                        $this->getParameter('cours_directory'), // Make sure this parameter is correctly defined in services.yaml
                        $newFilename
                    );
                    $cours->setFile($newFilename); // Set the filename (or path) to the entity
                } catch (FileException $e) {
                    throw $e;
                }
            }
    
            $entityManager->persist($cours);
            $entityManager->flush();
    
            $this->addFlash('success', 'The course has been successfully added.');
    
            return $this->redirectToRoute('app_cours');
        }
    
        return $this->render('Cours/back-end/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/GestionCours/show/{id}', name: 'show_cours')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $cours = $entityManager->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('The course does not exist');
        }

        return $this->render('Cours/back-end/show.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/GestionCours/edit/{id}', name: 'edit_cours')]
public function edit(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(CoursType::class, $cours);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $file */
        $file = $form->get('file')->getData();
        if ($file) {
            // Determine the path of the old file to remove it
            $oldFilename = $cours->getFile();
            if ($oldFilename) {
                $oldFilePath = $this->getParameter('cours_directory').'/'.$oldFilename;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Remove the old file
                }
            }

            // Process and save the new file
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = preg_replace('/[^a-zA-Z0-9]/', '_', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('cours_directory'),
                    $newFilename
                );
                $cours->setFile($newFilename);
            } catch (FileException $e) {
                throw $e;
            }
        }

        $entityManager->persist($cours);
        $entityManager->flush();

        $this->addFlash('success', 'Course updated successfully.');

        return $this->redirectToRoute('app_cours'); // Adjust the route name as needed
    }

    return $this->render('cours/back-end/edit.html.twig', [
        'cours' => $cours,
        'form' => $form->createView(),
    ]);
}

#[Route('/GestionCours/delete/{id}', name: 'delete_cours')]
public function delete(Request $request, EntityManagerInterface $entityManager, $id): Response
{
    $cours = $entityManager->getRepository(Cours::class)->find($id);

    if (!$cours) {
        $this->addFlash('error', 'Course not found');
        return $this->redirectToRoute('cours_index');
    }

    // Check for CSRF token to prevent CSRF attacks
    if ($this->isCsrfTokenValid('delete'.$cours->getId(), $request->request->get('_token'))) {
        $filePath = $this->getParameter('cours_directory') . '/' . $cours->getFile();
        if ($cours->getFile() && file_exists($filePath)) {
            unlink($filePath); // Remove the file
        }
        $entityManager->remove($cours);
        $entityManager->flush();
        $this->addFlash('success', 'Course successfully deleted');
    } else {
        $this->addFlash('error', 'Invalid token');
    }

    return $this->redirectToRoute('app_cours');
}
#[Route('/cours', name: 'front_cours')]
    public function afficher(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/front-end/index.html.twig', [
            'cours' => $coursRepository->findAll(),
         ]);
    }
    #[Route('/Cours/show/{id}', name: 'show_front_cours')]
    public function Frontshow(int $id, EntityManagerInterface $entityManager): Response
{
    $cour = $entityManager->getRepository(Cours::class)->find($id);

    if (!$cour) {
        throw $this->createNotFoundException('No certification found for id '.$id);
    }

    return $this->render('Cours/front-end/show.html.twig', [
        'cours' => $cour,
    ]);

} 

}
