<?php

namespace App\Controller;

use App\Form\ClientUserDateInvoiceFormType;
use App\Model\InvoicesTotal;
use App\Model\UsersData;
use App\PdfGenerator\MyPdf;
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
    public function create(Request $request, MyPdf $pdf, ClientHelper $clientHelper, ProductHelper $productHelper, InvoiceHelper $invoiceHelper,InvoiceProductHelper $invoiceProductHelper, InvoiceTotalHelper $invoiceTotalHelper): Response
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
            $productsData = $invoiceHelper->prepareInvoiceProductsData($invoiceId, $form);
            foreach ($productsData as $product){
                $invoiceProductHelper->createRecord($this->getUser()->getId(), $product);

            }
            $this->addFlash('success', 'Invoice' . $invoiceTotalData['name'] . 'has been created');
            return $this->redirectToRoute('invoice/show');
        }

        $userId = $this->getUser()->getId();
        $clientsList = $clientHelper->getListForUser($userId);
        $productList = $productHelper->getListForUser($userId);
        return $this->render('Invoice/generate.html.twig',[
            'settings' => array_merge(...$settings),
            'invoice_form' => $form->createView(),
            'clientsList' => $clientsList->isNotEmpty() ? $clientsList->toArray() : '',
            'productList' => $productList->isNotEmpty() ? $productList->toArray() : '',
        ]);
    }

    #[Route('/invoice/show', name: 'invoice/show')]
    public function show(InvoiceTotalHelper $invoiceTotalHelper)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $invoiceTotalData = $invoiceTotalHelper->getListToDisplay($this->getUser()->getId())->toArray();

        if (empty($invoiceTotalData)) {
            return new Response($this->renderView('Invoice/show.html.twig', [
                'msgEmptyList' => 'You do not have any invoices. You can add them&nbsp;',
                'msgLink' => $this->generateUrl('invoice_create'),
            ]));
        }

        return new Response($this->renderView('Invoice/show.html.twig', [
            'invoicesData' => $invoiceTotalData,
        ]));
    }

    #[Route('/download/id={id}', name: 'invoice_download')]
    public function download(int $id, InvoiceTotalHelper $invoiceTotalHelper, InvoiceProductHelper $invoiceProductHelper, mypdf $pdf, InvoiceHelper $invoiceHelper)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $invoice = $invoiceTotalHelper->getlistforuser($this->getuser()->getid())->where('ID', $id)->first();

        if (empty($invoice)) {
            $this->addflash('error', 'you are not allowed to download these invoice');
            return new response($this->redirecttoroute('invoice/show'));
        }
        $invoicedata = $invoiceProductHelper->getdataforinvoice($this->getuser()->getid(), $id);
        $preparedData = $invoiceHelper->prepareInvoiceDataFromDb($invoicedata->toArray());
        $pdf->downloadInvoice($preparedData);

    }
}


