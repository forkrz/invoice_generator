<?php

namespace App\PdfGenerator;

use Dompdf\Dompdf;
use Carbon\Carbon;
use Twig\Environment;
use Symfony\Component\HttpKernel\KernelInterface;

class MyPdf
{
    protected Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function downloadInvoice(array $invoiceData): void
    {
        $html = mb_convert_encoding($this->twig->render('Invoice\template_PDF.html.twig', ['invoiceTotalData' => $invoiceData['totalData'], 'invoiceProductData' => $invoiceData['productsData']]), 'HTML-ENTITIES', 'UTF-8');

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('defaultFont', 'Roboto');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();
        ob_end_clean();
        $dompdf->stream($invoiceData['totalData']['name'] . 'pdf', array('Attachment' => true));
    }

}