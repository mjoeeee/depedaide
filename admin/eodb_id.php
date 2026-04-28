<?php

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
require_once('../asset/tcpdf/tcpdf.php'); 
include 'query/eodb_id.php';

foreach ($results as $row):

$date = date('F j, Y');
// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
// set document information
$pdf->SetCreator(PDF_CREATOR);  
$pdf->SetTitle('EODB ID of : '.$row['firstname'].' '.$row['lastname']);  
// set default header data
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING); 
// set header and footer fonts 
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
// set default monospaced font
$pdf->SetDefaultMonospacedFont('helvetica');
// set margins  
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$pdf->SetMargins('2', '2', PDF_MARGIN_RIGHT);  
$pdf->setPrintHeader(false); 
$pdf->setPrintFooter(false);   
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
date_default_timezone_set('Asia/Manila');

// set auto page breaks
$pdf->SetAutoPageBreak('2','2', PDF_MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 8);  
$pdf->setJPEGQuality(72);
$pdf->AddPage('L','A6');
set_time_limit(0);
ini_set('memory_limit', '-1');

// Add images
$img_file = '../image/regularEODBID.png';
$pdf->Image($img_file, 5, 2, 150, '', '', '', '', false, 300, '', false, false, 0);
$pdf->Image('../'.$row['image'], 40, 73, 30, '', '', '', '', false, 150);
$pdf->Image('../image/logo.png', 95, 20, 22, '', '', '', false, 150);
$pdf->Image('../image/sdslago.png', 95, 28, 20, '', '', '', false, 150);
$fixedHeight = 15;   
$yPosition = 85;    
$xPosition = 100; 
$calculatedWidth = 0; 
$pdf->Image('../'.$row['sign'], $xPosition, $yPosition, $calculatedWidth, $fixedHeight, '', '', '', false, 0, '', false, false, 0, 'M', false, false);

// QR Code
$style = array(
    'border' => 0,
    'padding' => 0,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => array(255, 255, 255),
    'module_width' => 1,
    'module_height' => 1
);
$pdf->write2DBarcode('Official employee of DepEd Ozamiz with employee code:'.$row['emp_id'], 'QRCODE,L', 10, 70, 18, 18, $style, 'N');

// Prepare content
$firstname = $row['firstname'];
$lastname = $row['lastname'];

if ($row['job_title'] == 'Assistant Schools Division Superintendent') {
    $job_title = 'Asst. Schools Div. Superintendent';
} else {
    $job_title = $row['job_title'];
}

if (strlen($firstname) >= '11') {
    $first = '<font style="font-size: 14px; color:white;"><b>'.strtoupper($row['firstname']).' '.mb_substr($row['middlename'], 0, 1).'.</b></font><br>';
} else {
    $first = '<font style="font-size: 14px; color:white;"><b>'.strtoupper($row['firstname']).' '.strtoupper($row['extname']).''.mb_substr($row['middlename'], 0, 1).'.</b></font>';
}

if (strlen($lastname) >= '9') {
    $last = '<font style="font-size: 24px;"><b>'.strtoupper($row['lastname']).',</b></font><br>';
} else {
    $last = '<font style="font-size: 24px;"><b>'.strtoupper($row['lastname']).',</b></font>';
}

$contents = '
<table>
<tr>
<th width="100%" style="font-size: 85px"></th>
</tr>
<tr>
<th width="60%" style="font-size: 10px"></th>
<th width="40%" align="center"><b>NIMFA R. LAGO, PhD, CESO VI</b></th>
</tr>
<tr>
<th width="5%"></th>
<th width="55%" align="left" style="color:white;">'.$last.'</th>
<th align="center" width="40%" style="font-size: 8px">OIC, Office of the Schools Division Superintendent</th>
</tr>
<tr>
<th width="5%"></th>
<th width="55%">'.$first.'</th>
<th align="center" width="40%" style="font-size: 10px">'.strtoupper($row['emrgncy_name']).'<br>'.$row['emrgncy_no'].'</th>
</tr>
<tr>
<th width="100%" style="font-size: 14px"></th>
</tr>
<tr>
<th width="5%"></th>
<th width="85%" align="left" style="font-size: 10px; color: white"><b>'.$row['job_title'].'</b></th>
<th width="10%"></th>
</tr>
<tr>
<th width="100%" style="font-size: 0px"></th>
</tr>
<tr>
<th width="30%"></th>
<th width="45%" style="color: white; font-size: 14px"><b>'.$row['emp_id'].'</b></th>
<th align="left" width="50%" style="font-size: 10px;">'.$row['prc_no'].'<br>'.$row['tin_no'].'<br>'.$row['gsis_no'].'<br>'.$row['pagibig_no'].'<br>'.$row['philhealth_no'].'<br>'.$row['bday'].'<br>'.$row['blood_type'].'</th>
</tr>
<tr>
<th width="100%" style="font-size: 25px"></th>
</tr>
<tr>
<th width="58%"></th>
<th align="center"><b>'.strtoupper($row['firstname']).' '.mb_substr($row['middlename'], 0, 1).'. '.strtoupper($row['lastname']).'</b></th>
</tr>
</table>';

$pdf->writeHTMLCell(0, 0, 0, 3, $contents, 0, 1, 0, true, '', true);

$pdf->Output('eodb_id_' . $row['emp_id'] . '.pdf', 'I');

endforeach;




?>