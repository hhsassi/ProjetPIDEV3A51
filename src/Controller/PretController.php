<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pret')]
/**
 * @IsGranted("ROLE_USER")
 */
class PretController extends AbstractController
{
    #[Route('/', name: 'app_pret_index', methods: ['GET'])]
    public function index(PretRepository $pretRepository): Response
    {
        $prets = $pretRepository->findBy(  [], ['valeur' => 'DESC']);
        return $this->render('pret/index.html.twig', [
            'prets' => $prets
        ]);
    }

    #[Route('/single', name: 'app_pret_single', methods: ['GET'])]
    public function single(PretRepository $pretRepository): Response
    {
        $user = $this->getUser();

        return $this->render('pret/single.html.twig', [
            'prets' => $pretRepository->findBy(['user' => $user->getId()]),
        ]);
    }

    #[Route('/new', name: 'app_pret_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pret = new Pret();
        $options = [
            'is_admin' => in_array('ROLE_ADMIN', $this->getUser()->getRoles()),
            'user' => $this->getUser(),
        ];

        $form = $this->createForm(PretType::class, $pret, $options);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
            $pret->setUser($this->getUser());
            dump($pret);

            $entityManager->persist($pret);
            $entityManager->flush();
            $this->addFlash('success', 'Votre opération a été effectuée avec succès !');

            if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('app_pret_single', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pret/new.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pret_show', methods: ['GET'])]
    public function show(Pret $pret): Response
    {
//        dump($this->getUser()->getPret());
        return $this->render('pret/show.html.twig', [
            'pret' => $pret,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pret_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pret $pret, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pret);
            $entityManager->flush();

            return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pret/edit.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pret_delete', methods: ['POST'])]
    public function delete(Request $request, Pret $pret, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_pret_' . $pret->getId(), $request->request->get('csrf_token'))) {
            $entityManager->remove($pret);
            $entityManager->flush();
            $this->addFlash('success', 'Le prêt en question à été supprimé avec succéss');
        }

        return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/export', name: 'app_pret_export_clsx', methods: ['GET'])]
    public function createExcel(
        Request $request,
        Pret $pret,
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
            ->setCellValue('C1', 'Motif')
            ->setCellValue('D1', 'Salaire')
            ->setCellValue('E1', 'Garantie')
            ->setCellValue('F1', 'Valeur garantie')
            ->setCellValue('G1', 'Remboursements');

        // Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', $pret->getId())
            ->setCellValue('B2', $pret->getValeur())
            ->setCellValue('C2', $pret->getMotif())
            ->setCellValue('D2', $pret->getSalaire())
            ->setCellValue('E2', $pret->isGarantie() === 1 ? 'Oui' : 'Non')
            ->setCellValue('F2', $pret->getValeurGarantie())
            ->setCellValue('G2', $this->formatRemboursements($pret));

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Détail du prêt');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="detail-pret.xls"');
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

    private function formatRemboursements(Pret $pret): ?string
    {
        $remboursements = $pret->getRemboursements();
        $output = '';
        if ($remboursements) {
            foreach ($remboursements as $item) {
                $output .= (string)$item->getId() . ' ';
            }
        }

        return $output === '' ? '-' : $output;
    }
}
