<?php
try {
    // Get and sanitize request_id
    $request_id = filter_input(INPUT_GET, 'request_id', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query using a placeholder
    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_ictmrf_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'ict_maintenance' AND r.request_id = ?
                            ORDER BY r.created_at DESC
                          ");
    $stmt->execute([$request_id]);

    // Fetch single row
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["request_id"])) {
    // Sanitize input data
    $request_id = filter_var($_POST['request_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $name = htmlspecialchars($_POST['name']);
    $designation = htmlspecialchars($_POST['designation']);
    $divisionOffice = htmlspecialchars($_POST['divisionOffice']);
    $propertyDescription = htmlspecialchars($_POST['propertyDescription']);
    $brand = htmlspecialchars($_POST['brand']);
    $propertyNumber = htmlspecialchars($_POST['propertyNumber']);
    $serialNumber = htmlspecialchars($_POST['serialNumber']);
    $defects = htmlspecialchars($_POST['defects']);
    $inspectionDate = htmlspecialchars($_POST['inspectionDate']);
    $identifiedProblems = htmlspecialchars($_POST['identifiedProblems']);
    $technicalSupport = htmlspecialchars($_POST['technicalSupport']);
    $recommendations = htmlspecialchars($_POST['recommendations']);

    try {

        // Update tbl_ictmrf_depaide
        $stmt2 = $conn->prepare("UPDATE tbl_ictmrf_depaide 
                                 SET date_inspected = ?, IPI = ?, DTS = ?, recomend = ?, date_current = ?, time_current = ?, req_name = ?, 
                                    req_designation = ?, req_DO = ?, DOPE = ?, brand = ?, prop_no = ?, serial_no = ?, defects = ? 
                                 WHERE id = ?");
        $stmt2->execute([$inspectionDate, $identifiedProblems, $technicalSupport, $recommendations, $date, $time, $name, $designation, $divisionOffice, $propertyDescription, $brand, $propertyNumber, $serialNumber, $defects 
                        , $id]);

        // Redirect to ict_maintenance.php with success message
        header("Location: view_ict_maintenance?update=success&request_id=$request_id");
        exit(); 
        
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
} 
?>