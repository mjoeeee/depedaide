<?php
// include 'admin/query/view_ict_inspection.php';

try {
    // Get and sanitize request_id
    $request_id = filter_input(INPUT_GET, 'request_id', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query using a placeholder
    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_document_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'documentation' AND r.request_id = ?
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
    $title = htmlspecialchars($_POST['title']);
    $event_location = htmlspecialchars($_POST['event_location']);
    $event_date = htmlspecialchars($_POST['event_date']);
    $end_time = htmlspecialchars($_POST['end_time']);
    $start_time = htmlspecialchars($_POST['start_time']);
    $details = htmlspecialchars($_POST['details']);

    try {

        // Update tbl_ictmrf_depaide
        $stmt2 = $conn->prepare("UPDATE tbl_document_depaide 
                                 SET title = ?, event_location = ?, event_date = ?, end_time = ?, start_time = ?, details = ?
                                 WHERE id = ?");
        $stmt2->execute([$title, $event_location, $event_date, $end_time, $start_time, $details
                        , $id]);


        header("Location: view_documentation?update=success&request_id=$request_id");
        exit(); 
        
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>