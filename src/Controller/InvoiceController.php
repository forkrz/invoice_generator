<?php

namespace App\Controller;

use App\Form\InvoiceFormType;
use App\Model\Invoices;
use App\Model\UsersData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class InvoiceController extends AbstractController
{

    #[Route('/create', name: 'invoice_create')]
    public function index(Request $request): Response
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
        dump($form);
        return $this->render('Invoice/generate.html.twig',[
            'settings' => array_merge(...$settings),
            'invoice_form' => $form->createView(),
        ]);
    }
}


