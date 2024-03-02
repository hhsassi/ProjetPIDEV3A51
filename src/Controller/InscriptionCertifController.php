<?php

namespace App\Controller;

use App\Entity\InscriptionCertif;
use App\Form\InscriptionCertifType;
use App\Repository\InscriptionCertifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class InscriptionCertifController extends AbstractController
{
    #[Route('/GestionInscription', name: 'inscription_certif_index', methods: ['GET'])]
    public function index(InscriptionCertifRepository $inscriptionCertifRepository): Response
    {
        return $this->render('inscription_certif/back-end/index.html.twig', [
            'inscription_certifs' => $inscriptionCertifRepository->findAll(),
        ]);
    }
   

#[Route('/GestionInscriptionFront', name: 'inscription_certif_indexFront', methods: ['GET'])]
public function indexFront(InscriptionCertifRepository $inscriptionCertifRepository): Response
{
    $user = $this->getUser();
    $userId = $user ? $user->getId() : null;

    $inscriptions = $userId ? $inscriptionCertifRepository->findByUserId($userId) : [];

    return $this->render('inscription_certif/front-end/index.html.twig', [
        'inscription_certif' => $inscriptions,
    ]);
} 
#[Route('/gestion-inscription/{id}/pdf', name: 'inscription_certif_pdf')]
    public function generatePdf(int $id, InscriptionCertifRepository $inscriptionCertifRepository): Response
    {
        // Trouver l'inscription par ID
        $inscriptionCertif = $inscriptionCertifRepository->find($id);
        
        if (!$inscriptionCertif) {
            // Gérer l'erreur si l'inscription n'est pas trouvée
            $this->addFlash('error', 'Inscription non trouvée.');
            return $this->redirectToRoute('inscription_certif_index');
        }

        // Configurer Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        // Charger le HTML à partir du template Twig et passer la variable 'inscription'
        $html = $this->renderView('inscription_certif/pdf_template.html.twig', [
            'inscription' => $inscriptionCertif,
        ]);

        // Générer le PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Envoyer le PDF au navigateur
        $dompdf->stream("inscription-{$id}.pdf", [
            "Attachment" => true // Changez à false pour afficher dans le navigateur
        ]);

        return new Response('', 200, ['Content-Type' => 'application/pdf']);
    }



    #[Route('GestionInscription/new', name: 'inscription_certif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $inscriptionCertif = new InscriptionCertif();
        $form = $this->createForm(InscriptionCertifType::class, $inscriptionCertif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inscriptionCertif);
            $entityManager->flush();

            $email = (new Email())
    ->from('jarabnii@gmail.com') // Utilisez votre adresse email d'envoi réelle ici
    ->to($inscriptionCertif->getUser()->getEmail()) // S'assurer que l'entité InscriptionCertif est liée à User
    ->subject('Confirmation d\'inscription à une certification')
    ->html('
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: auto; padding: 20px; background-color: #f4f4f4; }
                .header { background-color: #007bff; color: white; text-align: center; padding: 10px; }
                .content { padding: 20px; text-align: center; }
                .footer { background-color: #333; color: white; text-align: center; padding: 10px; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Confirmation d\'Inscription</h1>
                </div>
                <div class="content">
                    <p>Bonjour ' . $inscriptionCertif->getUser()->getPrenom() . ',</p>
                    <p>Nous sommes heureux de confirmer votre inscription à la certification. Voici les détails de votre inscription :</p>
                    <ul>
                        <li>Nom de la certification : <strong>' . $inscriptionCertif->getCertification()->getNomCertif() . '</strong></li>
                        <li>Description : ' . $inscriptionCertif->getCertification()->getDescriotionCertif() . '</li>
                        <li>Durée : ' . $inscriptionCertif->getCertification()->getDureeCertif() . ' mois</li>
                    </ul>
                    <p>Nous vous souhaitons le meilleur dans cette nouvelle aventure d\'apprentissage !</p>
                </div>
                <div class="footer">
                    <p>&copy; ' . date('Y') . ' Artimis Bank. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>
    ');
 // Utilisez un template HTML si nécessaire

        // Envoyer l'email
        $mailer->send($email);
            

            $this->addFlash('success', 'Inscription ajoutée avec succès.');

            return $this->redirectToRoute('inscription_certif_index');
        }

        return $this->render('inscription_certif/back-end/new.html.twig', [
            'inscriptionCertif' => $inscriptionCertif,
            'form' => $form->createView(),
        ]);
        
    }
    // src/Controller/InscriptionCertifController.php

#[Route('GestionInscription/certif/{id}', name: 'inscription_certif_show', methods: ['GET'])]
public function show(InscriptionCertif $inscriptionCertif): Response
{
    return $this->render('inscription_certif/back-end/show.html.twig', [
        'inscriptionCertif' => $inscriptionCertif,
    ]);
}

#[Route('GestionInscription/{id}/edit', name: 'inscription_certif_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, InscriptionCertif $inscriptionCertif, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(InscriptionCertifType::class, $inscriptionCertif);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Inscription modifiée avec succès.');

        return $this->redirectToRoute('inscription_certif_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('inscription_certif/back-end/edit.html.twig', [
        'inscriptionCertif' => $inscriptionCertif,
        'form' => $form,
    ]);
    
}
// src/Controller/InscriptionCertifController.php

#[Route('/GestionInscription/{id}', name: 'inscription_certif_delete', methods: ['POST'])]
public function delete(Request $request, InscriptionCertif $inscriptionCertif, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$inscriptionCertif->getId(), $request->request->get('_token'))) {
        $entityManager->remove($inscriptionCertif);
        $entityManager->flush();
        $this->addFlash('success', 'Inscription supprimée avec succès.');
    }

    return $this->redirectToRoute('inscription_certif_index');
}





    // Ajoutez ici les méthodes new, show, edit, delete
}
