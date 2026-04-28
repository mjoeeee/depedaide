<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
require_once('../asset/tcpdf/tcpdf.php'); 
require_once('query/print_ict_maintenance.php'); 

foreach ($results as $row) :
    $date = date('F j, Y');
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('ITAF: '.$row['id']);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING); 
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetMargins(10, 10, 10);  
    $pdf->SetAutoPageBreak(true, 10); 
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    date_default_timezone_set('Asia/Manila');
    $pdf->SetFont('times', '', 11);
    $pdf->setJPEGQuality(72);
    $pdf->AddPage(); 
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $img_file = '../image/ict_maintenance.png';
    $page_width = $pdf->GetPageWidth();
    $page_height = $pdf->GetPageHeight();
    $left_margin = 8;
    $top_margin = 10;
    $img_width = $page_width - ($left_margin * 2);
    $img_height = $page_height - ($top_margin * 2);
    $x = ($page_width - $img_width) / 2;
    $y = $top_margin;
    $pdf->Image($img_file, $x, $y, $img_width, $img_height, '', '', '', true, 150, '', false, false, 0);

    $pdf->Ln();
    $pdf->StopTransform();

    $contents = '
    <table style="font-size:11px; border-collapse:separate; border-spacing: 0 4px; font-weight: bold;">
         
        <tr>
            <th width="29.7%"></th>
            <th><font>' . strtoupper($row['id']) . '</font></th>
        </tr>
        <tr>
            <th width="29.7%"></th>
            <th><font>' . (!empty($row['date_current']) ? date("F j, Y", strtotime($row['date_current'])) : 'N/A') . '</font></th>
        </tr>
        <tr>
            <th width="29.7%"></th>
            <th><font>' . (!empty($row['time_current']) ? date("h:i A", strtotime($row['time_current'])) : 'N/A') . '</font></th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="48%"></th>
            <th>' . strtoupper($row['req_name']) . '</th>
        </tr>
        <tr>
            <th width="48%"></th>
            <th>' . strtoupper($row['req_designation']) . '</th>
        </tr>
        <tr>
            <th width="48%"></th>
            <th>' . strtoupper($row['req_DO']) . '</th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th>' . strtoupper($row['DOPE']) . '</th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th>' . strtoupper($row['brand']) . '</th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th>' . strtoupper($row['prop_no']) . '</th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th>' . strtoupper($row['serial_no']) . '</th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th><font>' . (!empty($row['date_last_repair']) ? date("F j, Y", strtotime($row['date_last_repair'])) : 'N/A') . '</font></th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th>' . strtoupper($row['defects']) . '</th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr style="font-size:15px;">
            <th style="text-align: right;width: 45%;">
                ' . (!empty($row['date_inspected']) ? date("M j, Y", strtotime($row['date_inspected'])) : 'N/A') . '
            </th>

            <th width="10%"></th> 

            <th style="text-align: right; width: 20%;">
                ' . (!empty($row['date_inspected']) ? date("h:i A", strtotime($row['date_inspected'])) : 'N/A') . '
            </th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th width="70%">' . strtoupper($row['IPI']) . '</th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th width="70%">' . strtoupper($row['DTS']) . '</th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="34%"></th>
            <th></th>
        </tr>
        <tr>
            <th width="30%"></th>
            <th width="70%">' . strtoupper($row['recomend']) . '</th>
        </tr>

    </table>';

    

    $pdf->writeHTMLCell(0, 0, 0, 69, $contents, 0, 1, 0, true, '', true);
    $pdf->Output('ict_maintenance'.$row['request_id'].'.pdf', 'I');

endforeach;
?>