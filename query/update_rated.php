<?php

require_once '../config.php';

if (isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];

    try {
        $query = "UPDATE tbl_request_depaide SET rated = 1 WHERE request_id = :requestId";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':requestId', $requestId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Rated column updated successfully!";
        } else {
            echo "Error updating rated column.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Request ID not provided.";
}
?>
