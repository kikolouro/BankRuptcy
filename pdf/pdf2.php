<?php
session_start();
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
else die;

if ($id == $_SESSION['id']) {
    //============================================================+
    // File name   : example_001.php
    // Begin       : 2008-03-04
    // Last Update : 2013-05-14
    //
    // Description : Example 001 for TCPDF class
    //               Default Header and Footer
    //
    // Author: Nicola Asuni
    //
    // (c) Copyright:
    //               Nicola Asuni
    //               Tecnick.com LTD
    //               www.tecnick.com
    //               info@tecnick.com
    //============================================================+

    /**
     * Creates an example PDF TEST document using TCPDF
     * @package com.tecnick.tcpdf
     * @abstract TCPDF - Example: Default Header and Footer
     * @author Nicola Asuni
     * @since 2008-03-04
     */

    // Include the main TCPDF library (search for installation path).
    require_once('tcpdf_include.php');
    require_once('../connect.php');
    try {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATIONL, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Administrador BankRuptcy');
        $pdf->SetTitle('Contas do Utilizador ' . $_SESSION['Nome']);
        $pdf->SetSubject('Listagem das Contas');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE , PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        // Set some content to print

        $stmt = $db->prepare('Select Nome,Conta.*, TipoConta.Tipo 
        from TipoConta, Conta, uticonta, Utilizador 
        where Utilizador.iduti = :id and Conta.Tipo = TipoConta.idtipo  
        and uticonta.idconta = Conta.idconta 
        and Utilizador.iduti = uticonta.iduti 
        order by Conta.idconta');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $arr = $stmt->fetchAll();
        //echo $id;
        //echo json_encode($arr);
        $html = '<center><h1>Suas Contas</h1>
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
          <tr>
            <th style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">Código da Conta</th>
            <th style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">Tipo de Conta</th>
            <th style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">Iban</th>
            <th style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">Saldo</th>
            <th style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">Limite</th>
          </tr>
        </thead>
          <tbody>
          ';
        foreach ($arr as $key => $value) {
            //echo 'adad';
            $html .= '<tr><td style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">' . $value->idconta . '</td>';
            $html .= '<td style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">' . $value->Tipo . '</td>';
            $html .= '<td style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">' . $value->IBAN . '</td>';
            $html .= '<td style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;"> ' . $value->saldo . '</td>';
            $html .= '<td style="padding-left:20px; font-family:Arial; font-size:13px;  text-decoration:none; color:#000000;">' . $value->limite . '</td></tr>';
        }
        $html .= '</tbody></table>';
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        //echo $html;
        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //echo $html;
        $pdf->Output('Contas_' . $_SESSION['Nome'] . '.pdf', 'I');
    } catch (PDOException $ex) {
        echo $ex;
    }
}
//============================================================+
// END OF FILE
//============================================================+
