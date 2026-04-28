<?php
try {
    // Get and sanitize request_id
    $request_id = filter_input(INPUT_GET, 'request_id', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query using a placeholder
    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_inspection_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'ict_equipment_inspection' AND r.request_id = ?
                            ORDER BY r.created_at DESC
                          ");
    $stmt->execute([$request_id]);

    // Fetch single row
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Sanitize input data
    $request_id = filter_var($_POST['request_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $item = htmlspecialchars($_POST['item']);
    $property_no = htmlspecialchars($_POST['property_no']);
    $receipt_no = htmlspecialchars($_POST['receipt_no']);
    $acquisition_cost = htmlspecialchars($_POST['acquisition_cost']);
    $acquisition_date = htmlspecialchars($_POST['acquisition_date']);
    $complaints = htmlspecialchars($_POST['complaints']);
    $scope_last_repair = htmlspecialchars($_POST['scope_last_repair']);
    $defects = htmlspecialchars($_POST['defects']);
    $findings = htmlspecialchars($_POST['findings']);
    $parts_repair_replace = htmlspecialchars($_POST['parts_repair_replace']);
    $job_order_no = htmlspecialchars($_POST['job_order_no']);
    $amount = htmlspecialchars($_POST['amount']);
    $invoice_no = htmlspecialchars($_POST['invoice_no']);
    $comment_after_repair = htmlspecialchars($_POST['comment_after_repair']);


    try {

        // Update tbl_ictmrf_depaide
        $stmt2 = $conn->prepare("UPDATE tbl_inspection_depaide 
                                 SET item = ?, property_no = ?, receipt_no = ?, acquisition_cost = ?, acquisition_date = ?, complaints = ?, scope_last_repair = ?, 
                                    defects = ?, findings = ?, parts_repair_replace = ?, job_order_no = ?, amount = ?, invoice_no = ?, comment_after_repair = ?
                                 WHERE id = ?");
        $stmt2->execute([$item, $property_no, $receipt_no, $acquisition_cost, $acquisition_date, $complaints, $scope_last_repair, $defects, $findings, $parts_repair_replace, $job_order_no, $amount, $invoice_no, $comment_after_repair
                        , $id]);

        // Redirect to ict_maintenance.php with success message
        header("Location: view_ict_inspection?update=success&request_id=$request_id");
        exit(); 
        
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
} 
?>