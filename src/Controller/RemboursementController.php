<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Entity\Remboursement;
use App\Form\RemboursementType;
use App\Repository\RemboursementRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/remboursement')]
/**
 * @IsGranted("ROLE_USER")
 */
class RemboursementController extends AbstractController
{
    #[Route('/', name: 'app_remboursement_index', methods: ['GET'])]
    public function index(RemboursementRepository $remboursementRepository): Response
    {

        return $this->render('remboursement/index.html.twig', [
            'remboursements' => $remboursementRepository->findBy(  [], ['duree' => 'DESC'])
        ]);
    }

    #[Route('/new', name: 'app_remboursement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $remboursement = new Remboursement();
        $form = $this->createForm(RemboursementType::class, $remboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remboursement);
            $entityManager->flush();

            return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remboursement/new.html.twig', [
            'remboursement' => $remboursement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_remboursement_show', methods: ['GET'])]
    public function show(Remboursement $remboursement): Response
    {
        return $this->render('remboursement/show.html.twig', [
            'remboursement' => $remboursement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_remboursement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Remboursement $remboursement,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(RemboursementType::class, $remboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remboursement/edit.html.twig', [
            'remboursement' => $remboursement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_remboursement_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Remboursement $remboursement,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete_remboursement_' . $remboursement->getId(), $request->request->get('csrf_token'))) {
            $entityManager->remove($remboursement);
            $entityManager->flush();
            $this->addFlash('success', 'Le remboursement en question à été supprimé avec succéss');
        }

        return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/export', name: 'app_remboursement_export_clsx', methods: ['GET'])]
    public function createExcel(
        Request $request,
        Remboursement $remboursement,
        EntityManagerInterface $entityManager
    ): Response {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Nada LOUHICHI')
            ->setLastModifiedBy('Nada LOUHICHI')
            ->setTitle('Office 2007 XLSX Test Document');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Valeur')
            ->setCellValue('C1', 'Etat')
            ->setCellValue('D1', 'Durée')
            ->setCellValue('E1', 'Valeur tranche')
            ->setCellValue('F1', 'Associé au motif');

        // Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', $remboursement->getId())
            ->setCellValue('B2', $remboursement->getValeur())
            ->setCellValue('C2', $remboursement->getEtat())
            ->setCellValue('D2', $remboursement->getDuree())
            ->setCellValue('E2', $remboursement->getValeurTranche())
            ->setCellValue('F2', $remboursement->getPret()->getMotif())
        ;

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Détail de remboursement');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="detail-remboursement.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}
