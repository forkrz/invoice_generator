<?php

namespace App\PdfGenerator;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Twig\Environment;
use Symfony\Component\HttpKernel\KernelInterface;
class MyPdf
{
    protected $dateOfIssue;
    protected $realisedOn;
    protected Environment $twig;

    public function __construct(Environment $twig,KernelInterface $appKernel){
        $this->twig = $twig;
        $this->kernel = $appKernel;
    }

    public function setDateOfIssue($date){
        $this->dateOfIssue = $date;
    }

    public function setRealisedOn($date){
        $this->realisedOn = $date;
    }

    public function test($userData, $formData){
        $userKey = $userData->getInvoiceUniqueKey();
        $html = mb_convert_encoding($this->twig->render('Invoice\template_PDF.html.twig',['userKey' => $userKey, 'form' => $formData]), 'HTML-ENTITIES', 'UTF-8');

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('defaultFont', 'Roboto');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();
        ob_end_clean();
        $dompdf->stream('my.pdf',array('Attachment'=>0));
    }

//
//    public function createTable($products): string{
//
//        $html =
//            '<table cellspacing="0" cellpadding="3" border="1" style="border-color:gray;">
//    <tr style="background-color:gray; color:white; text-align:center" size="20">
//        <td>Lp.</td>
//        <td width="210">Name</td>
//        <td width="50">Quantity</td>
//		<td>Net Price</td>
//		<td>Net Value</td>
//		<td>Tax Rate</td>
//		<td>Tax Value</td>
//		<td>Gross Price</td>
//    </tr>';
//
//            $html .= '<tr>';
//            $html .= '<td> 15 </td>';
//            $html .= '<td>' . $products->Product['PRODUCT_NAME'] . '</td>';
//            $html .= '<td>' . $products->Product['QUANTITY'] . '</td>';
//            $html .= '<td>' . $products->Product['NET_PRICE'] . '</td>';
//            $html .= '<td>' . $products->Product['TAX_RATE'] . '</td>';
//            $html .= '<td>' . $products->Product['TAX_RATE'] . '</td>';
//            $html .= '<td>' . $products->Product['TOTAL_GROSS_PRICE'] . '</td>';
//            $html .= '<td>' . $products->Product['TOTAL_GROSS_PRICE'] . '</td>';
//            $html .= '</tr>';
//
//
//        $html .= '</table>';
//        return $html;
//    }

}