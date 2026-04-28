<?php
include '../config.php';
try {
    // Fetch event details
    $stmt = $conn->prepare("SELECT d.*, r.*, u.*
                            FROM tbl_softdev_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'software_development'
                            AND r.userId = :userId                            
                            ORDER BY r.updated_at DESC
                          ");
    $stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);                          
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results); 
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>