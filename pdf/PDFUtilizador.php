<?php
session_start();
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
else die;

if ($id != $_SESSION['id']) {
    if ($_SESSION['cargo'] != 3)
        echo "<meta charset='UTF-8'><h1><center>Não seja sacaninha pah!</center></h1>";
}
//echo "ola1";

require("tcpdf_include.php");
require_once('../connect.php');
try {
    //echo "ola1";
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrador BankRuptcy');
    $pdf->SetTitle('Informações do Utilizador ' . $_SESSION['Nome']);
    $pdf->SetSubject('Listagem do Utilizador');

    $stmt = $db->prepare('select * from Utilizador where :id = iduti');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();


    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
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
    if (@file_exists(dirname(__FILE__) . $_SESSION['foto'])) {
        require_once(dirname(__FILE__) .  $_SESSION['foto']);
        $pdf->setLanguageArray($l);
    }
    $pdf->AddPage();
    //echo "ola1";
    /*Conteúdo que irá aparecer no PDF*/
    foreach ($arr as $key => $value) {
        $html = "<meta charset='UTF-8'>
        <div align='center'>
        <h1>Listagem do Utilizador</h1>
                Nome: " . $value->Nome;
        $html .= " <br>Cartão de Cidadão: " . $value->CC;

        $html .= " <br>Login: " . $value->Login;

        $html .= " <br>Email: " . $value->email;

        $html .= " <br>Data de Nascimento: " . $value->datanasc;
        $html .= " <br>Morada: " . $value->morada;
        $html .= " <br>Telefone: " . $value->telefone;
        $html .= '<br> Foto: <br><img width="100" height="100" src="../' . $value->Foto . '"></div>';
    }
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output('Informacoes:' . $_SESSION['Nome'], 'I');
} catch (PDOException $ex) {
    echo $ex;
}
