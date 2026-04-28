<?php

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
require_once('../asset/tcpdf/tcpdf.php'); 
include 'query/eodb_idBB.php';

foreach ($results as $row) :

    // create new PDF document
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    // set document information
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('EODB ID BB of : '.$row['firstname'].' '.$row['lastname']);  
    // set default header data
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING); 
    // set header and footer fonts 
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont('helvetica');
    // set margins  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins('10', '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false); 
    $pdf->setPrintFooter(false);   
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->setJPEGQuality(72);
    $pdf->AddPage(); 
    set_time_limit(0);
    ini_set('memory_limit', '-1');


    if ($row['employ_status'] == 'Casual') {
        $img_file = "../image/contractualEODBIDBB.png";
    } elseif ($row['employ_status'] == 'Permanent') {
        $img_file = "../image/regularEODBIDBB.png";
    } else {
        $img_file = "../image/officialEODBIDBB.png";
    }
    

    $pdf->Image($img_file, 8, -.50, 198, 149, '', '', '', false, 300, '', false, false, 0);
   
    $pdf->Image('../'.$row['image'] , 61, 101, 45,45, '', '', '', false, 150);
    
    $pdf->Image('../'.$row['image'] , 163, 101, 45,45, '', '', '', false, 150);


         $style = array('border' => '', 'fgcolor' => array(0,0,0), 'bgcolor' => false, 'module_width' => 1, 'module_height' => 1);
         $pdf->write2DBarcode('Official employee of DepEd Ozamiz with employee code: '. $row['emp_id'], 'QRCODE,L', 20, 101, 25, 25, $style);
         $pdf->write2DBarcode('Official employee of DepEd Ozamiz with employee code: '. $row['emp_id'], 'QRCODE,L', 123, 101, 25, 25, $style);

    $lastname_letters = strlen(strtoupper($row['lastname']));
    $firstname_letters = strlen(strtoupper($row['firstname']));
    $jobtitle_letters = strlen(strtoupper($row['job_title']));
    if ($lastname_letters > 9) {
        $font = '33';
    } else {
        $font = '36';
    }

    if ($firstname_letters >= 11 && $firstname_letters <= 16) {
        $size = '20';
    } elseif($firstname_letters > 16){
	$size = '18';
	} else {
        $size = '25';
    }

    if ($jobtitle_letters >= 30) {
        $job_size = '13';
    } elseif($jobtitle_letters >= 21 && $jobtitle_letters <= 29) {
        $job_size = '15';
    } else {
	$job_size = '20';
	}

    if (($row['employ_status']) == 'Casual') {
        $lastname = '<font style="font-size: '.$font.'px; color: black"><b>'.strtoupper($row['lastname']).',</b></font>';
        $fmname = '<font style="font-size: '.$size.'px; color:black;"><b>'.strtoupper($row['firstname']).' '.mb_substr($row['middlename'], 0,1).'. '.strtoupper($row['extname']).'</b></font>';
        $job_title = '<font style="font-size: '.$job_size.'px; color: black"><b>'.($row['job_title']).'</b></font>';
        $employee_id = '<font style="color: black; font-size: 18px;"><b>ID NO.'.($row['emp_id']).'</b></font>';
    }else{
        $lastname = '<font style="font-size: '.$font.'px; color: white"><b>'.strtoupper($row['lastname']).',</b></font>';
        $fmname = '<font style="font-size: '.$size.'px; color: white"><b>'.strtoupper($row['firstname']).' '.mb_substr($row['middlename'], 0,1).'. '.strtoupper($row['extname']).'</b></font>';
        $job_title = '<font style="font-size: '.$job_size.'px; color: white"><b>'.($row['job_title']).'</b></font>';
        $employee_id = '<font style="color: white; font-size: 18px;"><b>ID NO.'.($row['emp_id']).'</b></font>';
    }

        $contents ='
        <table>
        <tr>
        <th width="100%" style="font-size: 140px"></th>
        </tr>
    
    <tr>
	
    <th width="2%"></th>
    <th width="56%" align="left" style="color:white;">'.$lastname.'</th>
    <th width="54%" align="left" style="color:white;">'.$lastname.'</th>
    
    </tr>
    <tr>
    <th width="2%"></th>
    <th width="56%">'.$fmname.'</th>
    <th width="60%">'.$fmname.'</th>
    </tr>
   <tr>
<th style="font-size: 5px"></th>
</tr>
<tr>
<th width="2%"></th>
<th width="56%" >'.$job_title.'</th>
<th width="60%" >'.$job_title.'</th>
</tr>

<tr>
<th style="font-size: 10px"></th>
</tr>

<tr>
<th width="2%"></th>
<th width="56%">'.$employee_id.'</th>
<th width="60%">'.$employee_id.'</th>
</tr>


</table>';

endforeach;

        $pdf->writeHTML($contents);  
        $pdf->Output('eodb_idBB_' . $row['emp_id'] . '.pdf', 'I');
   
?>