<?php

namespace App\Controller;

use App\Form\ClientUserDateInvoiceFormType;
use App\Model\InvoicesTotal;
use App\Model\UsersData;
use App\PdfGenerator\PdfGenerator;
use App\Service\ControllersHelpers\InvoiceHelper;
use App\Service\DbHelpers\ClientHelper;
use App\Service\DbHelpers\InvoiceProductHelper;
use App\Service\DbHelpers\InvoiceTotalHelper;
use App\Service\DbHelpers\ProductHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{

    #[Route('/create', name: 'invoice_create')]
    public function create(Request $request, PdfGenerator $pdf, ClientHelper $clientHelper, ProductHelper $productHelper, InvoiceHelper $invoiceHelper,InvoiceProductHelper $invoiceProductHelper, InvoiceTotalHelper $invoiceTotalHelper): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $settings = UsersData::query()
            ->select()
            ->where('user_id',$this->getUser()->getId())
            ->get()
            ->toArray();

        $invoice = new InvoicesTotal();
        $form = $this->createForm(ClientUserDateInvoiceFormType::class,$invoice);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $invoiceTotalData = $invoiceHelper->prepareInvoiceTotalData($form);
            $invoiceId = $invoiceTotalHelper->createRecord($this->getUser()->getId(), $invoiceTotalData);
            $productData = $invoiceHelper->prepareInvoiceProductsData($invoiceId, $form);
            foreach ($productData as $product){
                $invoiceProductHelper->createRecord($this->getUser()->getId(), $product);

            }
            dd('xd');
        }

        $userId = $this->getUser()->getId();
        $clientsList = $clientHelper->getListForUser($userId)->toArray();
        $productList = $productHelper->getListForUser($userId)->toArray();
        return $this->render('Invoice/generate.html.twig',[
            'settings' => array_merge(...$settings),
            'invoice_form' => $form->createView(),
            'clientsList' => $clientsList,
            'productList' => $productList,
        ]);
    }
}


