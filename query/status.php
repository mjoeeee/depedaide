<?php
$userId = $_SESSION['userId'];
$stmt = $conn->prepare("SELECT * FROM tbl_request_depaide WHERE userId = :userId ORDER BY updated_at DESC");
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    try {
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception("Request ID is required.");
        }

        $requestId = $_POST['id'];

        // Fetch request details
        $fetchStmt = $conn->prepare("SELECT request_type_id, request_type_table FROM tbl_request_depaide WHERE request_id = :requestId AND userId = :userId ORDER BY updated_at DESC");
        $fetchStmt->execute([':requestId' => $requestId, ':userId' => $userId]);
        $request = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        if (!$request) {
            throw new Exception("No request found or unauthorized action.");
        }

        $requestTypeId = $request['request_type_id'];
        $requestTypeTable = $request['request_type_table'];

        $tableMap = [
            'ict_maintenance' => 'tbl_ictmrf_depaide',
            'software_development' => 'tbl_softdev_depaide',
            'ict_equipment_inspection' => 'tbl_inspection_depaide',
            'documentation' => 'tbl_document_depaide',
            'audio_visual_editing' => 'tbl_audiovisual_depaide',
            'deped_email_request' => 'tbl_depedemail_depaide',
            'password_reset' => 'tbl_passreset_depaide',
            'id_card_printing' => 'tbl_printingid_depaide',
        ];

        if (!isset($tableMap[$requestTypeTable])) {
            throw new Exception("Invalid request type.");
        }

        $tableName = $tableMap[$requestTypeTable];

        // Check if the table requires deleting an attachment or images
        if ($tableName === 'tbl_softdev_depaide' || $tableName === 'tbl_passreset_depaide') {
            // Fetch the attachment filename
            $fetchAttachmentStmt = $conn->prepare("SELECT attachment FROM $tableName WHERE id = :requestTypeId");
            $fetchAttachmentStmt->execute([':requestTypeId' => $requestTypeId]);
            $attachment = $fetchAttachmentStmt->fetchColumn();

            if ($attachment) {
                $filePath = $attachment; // Adjust the path as needed
                if (file_exists($filePath)) {
                    unlink($filePath); // Delete the file
                }
            }
        }

        if ($tableName === 'tbl_printingid_depaide') {
            // Fetch image and sign filenames
            $fetchImagesStmt = $conn->prepare("SELECT image, sign FROM $tableName WHERE id = :requestTypeId");
            $fetchImagesStmt->execute([':requestTypeId' => $requestTypeId]);
            $images = $fetchImagesStmt->fetch(PDO::FETCH_ASSOC);

            if ($images) {
                if (!empty($images['image']) && file_exists($images['image'])) {
                    unlink($images['image']); // Delete image file
                }
                if (!empty($images['sign']) && file_exists($images['sign'])) {
                    unlink($images['sign']); // Delete sign file
                }
            }
        }


        // Delete from mapped table
        $deleteStmt = $conn->prepare("DELETE FROM $tableName WHERE id = :requestTypeId");
        $deleteStmt->execute([':requestTypeId' => $requestTypeId]);

        // Delete from main request table
        $deleteRequestStmt = $conn->prepare("DELETE FROM tbl_request_depaide WHERE request_id = :requestId AND userId = :userId");
        $deleteRequestStmt->execute([':requestId' => $requestId, ':userId' => $userId]);

        if ($deleteRequestStmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Request cancelled successfully']);
        } else {
            throw new Exception("Failed to cancel request.");
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
?>