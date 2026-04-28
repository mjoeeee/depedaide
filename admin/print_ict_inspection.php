<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
require_once('../asset/tcpdf/tcpdf.php'); 
require_once('query/print_ict_inspection.php'); 


foreach ($results as $row) :
    $date = date('F j, Y');
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('ITAF: '.$row['item']);  
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
    $img_file = '../image/ict_inspection.jpg';

    // Get page dimensions
    $page_width = $pdf->GetPageWidth();
    $page_height = $pdf->GetPageHeight();
    
    // Set margins
    $left_margin = 20;
    $top_margin = 5;
    
    // Define image width (fit within page margins)
    $img_width = $page_width - ($left_margin * 2);
    
    // Maintain aspect ratio
    list($original_width, $original_height) = getimagesize($img_file);
    $aspect_ratio = $original_width / $original_height;
    $img_height = $img_width / $aspect_ratio;
    
    // Center horizontally
    $x = ($page_width - $img_width) / 2;
    
    // Center vertically
    $y = ($page_height - $img_height) / 2;
    
    // Add the image to the PDF
    $pdf->Image($img_file, $x, $y, $img_width, $img_height, '', '', '', true, 150, '', false, false, 0);
    
    $pdf->Ln();
    $pdf->StopTransform();

    $contents = '

    <style>
    .one-line {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .two-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        max-height: 3em;
        line-height: 1.5em;
    }
    .three-lines {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        max-height: 4.5em;
        line-height: 1.5em;
    }
</style>

    <table style="font-size:11px; border-collapse:separate; border-spacing: 0 4.6px; font-weight: bold;">
         
        <tr>
            <th width="25%"></th>
            <th width="70%" class="one-line"><font>' . strtoupper($row['item']) . '</font></th>
        </tr>
        <tr>
            <th style="text-align: right;width: 40%;" class="one-line">
                ' . strtoupper($row['property_no']). '
            </th>
            <th width="28%"></th> 
            <th style="text-align: right; width: 20%;" class="one-line">
                ' . strtoupper($row['receipt_no']) . '
            </th>
        </tr>
        <tr>
            <th style="text-align: right;width: 31%;" class="one-line">
                ' . strtoupper($row['acquisition_cost']). '
            </th>
            <th width="18%"></th> 
            <th style="text-align: right; width: 20%;" class="one-line">
                ' . strtoupper($row['acquisition_date']) . '
            </th>
        </tr>
        <tr>
            <th width="42%"></th>
            <th width="55%" class="two-lines"><font>' . strtoupper($row['scope_last_repair']) . '</font></th>
        </tr>
        
        <tr>
            <th width="25%"></th>
            <th width="70%"><font>' . strtoupper($row['complaints']) . '</font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font>' . strtoupper($row['fullname']) . '</font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <br>
                <br>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font>' . strtoupper($row['defects']) . '</font></th>
        </tr>
        
        <tr>
            <th width="31%"></th>
            <th width="62%"><font></font><font>' . strtoupper($row['findings']) . '</font></th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <tr>
            <th width="46%"></th>
            <th width="50%"><font></font><font>' . strtoupper($row['parts_repair_replace']) . '</font></th>
        </tr>
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
                        <tr>
            <th width="25%"></th>
            <th width="70%"><font></font><font></font></th>
        </tr>
        <br>     
        <br>
        <tr>
            <th style="text-align: right;width: 38%;">
                ' . strtoupper($row['job_order_no']). '
            </th>
            <th width="5%"></th> 
            <th style="text-align: right; width: 20%;">
                ' . strtoupper($row['amount']) . '
            </th>
            <th width="5%"></th> 
            <th style="text-align: right; width: 17%;">
                ' . strtoupper($row['invoice_no']) . '
            </th>
        </tr>
        <tr>
            <th width="25%"></th>
            <th width="60%"><font></font><font>' . strtoupper($row['comment_after_repair']) . '</font></th>
        </tr>
    </table>';

    

    $pdf->writeHTMLCell(0, 0, 0, 69, $contents, 0, 1, 0, true, '', true);
    $pdf->Output('ict_inspection'.$row['request_id'].'.pdf', 'I');

endforeach;
?>