<?php
require_once '../config.php';

session_start();

try {

    $stmt = $conn->prepare("SELECT request_id, request_type_table 
                            FROM tbl_request_depaide 
                            WHERE rated = 0 AND stat = 'Completed' 
                            AND userId = :userId");

    $stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);

    $stmt->execute();

    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['unratedRequests' => $requests]);

} catch (PDOException $e) {

    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'An error occurred while fetching data.']);
}
?>