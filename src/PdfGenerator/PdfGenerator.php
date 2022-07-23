<?php

namespace App\PdfGenerator;
use App\PdfGenerator\MyPdf;
use Carbon\Carbon;

class PdfGenerator
{
    protected MyPdf $tcpdf;

    public function __construct(MyPdf $tcpdf)
    {
        $this->tcpdf = $tcpdf;
    }

    public function create($userData, $formData)
    {

        $title = $userData->getInvoiceUniqueKey() . '/' . Carbon::today()->format('d/m/Y') . '/' . '1';

        $pdf = new MyPdf('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->SetAuthor($userData->getUserName());
        $pdf->SetTitle($title);

        //header
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setDateOfIssue(Carbon::today()->format('d/m/Y'));
        $pdf->setRealisedOn(Carbon::today()->format('d/m/Y'));
        $pdf->SetHeaderMargin('10');
        $pdf->AddPage();

        // number of invoice
        $grey = $pdf->SetFillColor(249,249,249);
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'',20);
        $pdf->Cell(0, 10, 'Invoice: ' . $title, 'TB', null, 'C', $grey);
        $pdf->Ln(20);

        // user and client data
        $pdf->MultiRow('Seller', 'Buyer', 'B', 'J');
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'',10);
        $pdf->Ln(4);
        $pdf->MultiRow('Street: ' . $formData->USER_NAME, 'Street: ' . $formData->CLIENT_NAME, 0, 'L');
        $pdf->Ln(1);
        $pdf->MultiRow($formData->USER_ZIP_CODE . ' ' . $formData->USER_CITY, $formData->CLIENT_ZIP_CODE . ' ' . $formData->CLIENT_CITY, 0, 'L');
        $pdf->Ln(1);
        $pdf->MultiRow('NIP: ' . $formData->USER_NIP,'NIP: ' . $formData->CLIENT_NIP, 0, 'L');
        $pdf->Ln(1);
        $pdf->MultiRow('EMAIL: ' . $formData->USER_EMAIL,'EMAIL: ' . $formData->CLIENT_EMAIL, 0, 'L');
        $pdf->Ln(10);
        //product table

        $pdf->writeHTMLCell(182, 0, '', '', $pdf->createTable(), 0, 1, 0, true, '', true);


        $pdf->Output($title . ".pdf",'I'); // This will output the PDF as a response directly
    }
}