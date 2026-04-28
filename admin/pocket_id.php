<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
require_once('../asset/tcpdf/tcpdf.php'); 
include 'query/pocket_id.php';


foreach ($results as $row) :
    $date = date('F j, Y');

    // Create new PDF document
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Pocket ID of : '.$row['firstname'].' '.$row['lastname']);  

    // Set default header data
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING); 

    // Set header and footer fonts 
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont('helvetica');

    // Set margins  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    date_default_timezone_set('Asia/Manila');

    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->setJPEGQuality(72);
    $pdf->AddPage(); 
    set_time_limit(0);
    ini_set('memory_limit', '-1');

    // Load images
    $img_file = '../image/idtemplate.png';
    $pdf->Image($img_file, 12, 2, 188, 70, '', '', '', true, 150, '', false, false, 0);
    $pdf->Image('../' . $row['image'], 22.7, 22.7, 22.7, 22.7, '', '', false, 150);
    $pdf->Image('../'. $row['sign'], 120, 40, 15, '', '', '', '', false, 300, '', false, false);

    // QR Code style
    $qr_style = array(
        'border' => '',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    // QR Code
    $pdf->write2DBarcode($row['emp_id'], 'QRCODE,L', 159, 27, 22, 22, $qr_style, 'N');

    // Barcode style
    $barcode_style = array(
        'position' => '',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255),
        'stretchtext' => 4
    );
$barcode_data = strtoupper($row['emp_id']);

    $pdf->StartTransform();
    $pdf->Rotate(90, 100, 40);
    $pdf->write1DBarcode($barcode_data, 'C39', 87, 32.5, 30, 10, '', $barcode_style, 'N');



    $pdf->Ln();
    $pdf->StopTransform();

    if (strlen($row['firstname']) >= 16) {
        $first = '<font style="font-size: 9">'.strtoupper($row['firstname']).' '.substr($row['middlename'],0,1).' '.strtoupper($row['ext_name']).'</font>';
    } else {
        $first = '<font>'.strtoupper($row['firstname']).' '.substr($row['middlename'],0,1).' '.strtoupper($row['ext_name']).'</font>';
    }


    $contents = '
    <table>
    <tr>
    <th width="52%"></th>
    <th><font>In case of emergency, please contact : </font></th>
    </tr>
    <tr>
    <th width="52%" style="font-size: 3px;"></th>
    <th style="font-size: 10px; font-style: italic"><font style="color: #0003ff">Name : </font><font>   </font>'.strtoupper($row['emrgncy_name']).'</th>
    </tr>
    <tr>
    <th width="52%" style="font-size: 3px;"></th>
    <th style="font-size: 10px; font-style: italic"><font style="color: #0003ff">Number : </font>'.$row['emrgncy_no'].'</th>
    </tr>
    <tr>
    <th width="52%"></th>
    <th style="font-size: 10px; font-style: italic"><font style="color: #0003ff">Email : </font><font>   </font>'.$row['emrgncy_email'].'</th>
    </tr>
    <tr>
    <th style="font-size: 8px"></th>
    </tr>
    <tr>
    <th width="18%"></th>
    <th width="34%" style="font-size: 20px;">'.strtoupper($row['lastname']).'</th>
    
    <th style="font-size: 10px; font-style: italic;"><font style="color: #0003ff;">PRC No. : </font> <font>    </font> <font>    </font> <font>  </font>'.$row['prc_no'].'<br><font style="color: #0003ff;">TIN : </font> <font>    </font> <font>    </font> <font>    </font> <font>    </font>  <font>  </font>'.$row['tin_no'].'<br><font style="color: #0003ff;">GSIS No. : </font> <font>    </font> <font>   </font> '.$row['gsis_no'].'</th>
    </tr>
    <tr>
    <th width="18%"></th>
    <th width="34%">'.$first.' </th>
    <th style="font-size: 10px; font-style: italic"><font style="color: #0003ff">PAG-IBIG No. : </font> <font> </font>'.$row['pagibig_no'].'<br><font style="color: #0003ff">PhilHealth No. : </font> '.$row['philhealth_no'].'</th>
    </tr>
    <tr>
    <th width="18%" style="font-size: 18px"></th>
    <th>'.$row['emp_id'].'</th>
    </tr>
    <tr>
    <th style="font-size:7px"></th>
    </tr>
    <tr>
    <th width="5.5%"></th>
    <th>'.$row['bday'].'</th>
    </tr>
    </table>';
    // $pdf->writeHTML($contents, true, false, true, false, '');

    $pdf->writeHTMLCell(0, 0, 14, 5, $contents, 0, 1, 0, true, '', true);
    // Output PDF
    $pdf->Output('pocket_id_'.$row['emp_id'].'.pdf', 'I');

endforeach;
?>