<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\InvoiceFormType;
use App\Model\Invoices;
use App\Model\UsersData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\PdfGenerator\PdfGenerator;
use App\Entity\Users;

class InvoiceController extends AbstractController
{

    #[Route('/create', name: 'invoice_create')]
    public function index(Request $request, PdfGenerator $pdf, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $settings = UsersData::query()
            ->select()
            ->where('user_id',$this->getUser()->getId())
            ->get()
            ->toArray();

        $invoice = new Invoices();
        $form = $this->createForm(InvoiceFormType::class,$invoice);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userData = $entityManager->getRepository(Users::class)->find($this->getUser());
            $formData = $form->getData();
            $pdf->create($userData, $formData);
        }
        return $this->render('Invoice/generate.html.twig',[
            'settings' => array_merge(...$settings),
            'invoice_form' => $form->createView(),
        ]);
    }
}


