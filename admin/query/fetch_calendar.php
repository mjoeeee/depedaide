<?php
include '../../config.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['type']) && !isset($_GET['request_id']) && !isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing request type, user ID, or request ID"], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $query = "";
    $params = [];

    if (isset($_GET['request_id']) && $_GET['request_id'] === "all") {
        $query = "SELECT r.*, u.fullname
                  FROM tbl_request_depaide r
                  JOIN tbl_user u ON r.userId = u.userId
                  ORDER BY r.updated_at DESC";
    } elseif (isset($_GET['user_id'])) {
        $query = "SELECT r.*, u.fullname
                  FROM tbl_request_depaide r
                  JOIN tbl_user u ON r.userId = u.userId
                  WHERE r.userId = :user_id
                  ORDER BY r.updated_at DESC";
        $params = [':user_id' => $_GET['user_id']];
    } elseif (isset($_GET['type'])) {
        $tableMapping = [
            "audio_visual_editing" => "tbl_audiovisual_depaide",
            "documentation" => "tbl_document_depaide",
            "software_development" => "tbl_softdev_depaide"
        ];

        $requestType = $_GET['type'];

        if (!isset($tableMapping[$requestType])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid request type"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $query = "SELECT d.*, r.*, u.fullname
                  FROM {$tableMapping[$requestType]} d
                  JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                  JOIN tbl_user u ON r.userId = u.userId
                  WHERE r.request_type_table = :requestType
                  ORDER BY r.updated_at DESC";
        $params = [':requestType' => $requestType];
    }

    if ($query) {
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}
?>
