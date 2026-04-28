<?php
include '../config.php';
session_start();

try {

    if (!isset($_SESSION['userId'])) {
        echo json_encode(['error' => 'User  ID not found in session.']);
        exit;
    }


    $stmt = $conn->prepare("SELECT d.*, r.*, u.*
                            FROM tbl_document_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'documentation'
                            AND r.userId = :userId
                            ORDER BY r.updated_at DESC
                          ");
    
    $stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);
    
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results); 
} catch (PDOException $e) {
    error_log("Query failed: " . $e->getMessage());
    
    echo json_encode(['error' => 'An error occurred while fetching data.']);
}
?>