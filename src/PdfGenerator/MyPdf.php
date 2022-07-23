<?php

namespace App\PdfGenerator;

class MyPdf extends \TCPDF
{
    protected $dateOfIssue;
    protected $realisedOn;

    public function setDateOfIssue($date){
        $this->dateOfIssue = $date;
    }

    public function setRealisedOn($date){
        $this->realisedOn = $date;
    }

    public function header()
    {
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Title
        $this->Cell(0, 20,'Invoice Date: ' . $this->dateOfIssue, 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 20, 'Realised on: ' . $this->realisedOn, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }

    public function MultiRow($left, $right, $border, $align) {
        $this->SetFillColor(255,255,255);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

        $page_start = $this->getPage();
        $y_start = $this->GetY();

        // write the left cell
        $this->setCellMargins(0, 0 , 60);
        $this->MultiCell(60, 0, $left, $border, $align, 1, 0, '', '', true, 0);

        $page_end_1 = $this->getPage();
        $y_end_1 = $this->GetY();

        $this->setPage($page_start);

        // write the right cell

        $this->MultiCell(60, 0, $right, $border, $align, 1, 1, $this->GetX() ,$y_start, true, 0);

        $page_end_2 = $this->getPage();
        $y_end_2 = $this->GetY();

        // set the new row position by case
        if (max($page_end_1,$page_end_2) == $page_start) {
            $ynew = max($y_end_1, $y_end_2);
        } elseif ($page_end_1 == $page_end_2) {
            $ynew = max($y_end_1, $y_end_2);
        } elseif ($page_end_1 > $page_end_2) {
            $ynew = $y_end_1;
        } else {
            $ynew = $y_end_2;
        }

        $this->setPage(max($page_end_1,$page_end_2));
        $this->SetXY($this->GetX(),$ynew);
    }

    public function createTable(): string{
        $html =
            '<table cellspacing="0" cellpadding="1" border="1" style="border-color:gray;">
    <tr style="background-color:gray; color:white; text-align:center">
        <td>Lp.</td>
        <td>Name</td>
        <td>Quantity</td>
		<td>Net Price</td>
		<td>Tax Rate</td>
		<td>Net Value</td>
		<td>Tax Value</td>
		<td>Gross Price</td>
    </tr>
</table>';

        return $html;
    }

}