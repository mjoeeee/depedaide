<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST['reason'])) {
            throw new Exception("Reason is required.");
        }

        $userId = $_SESSION['userId']; 
        $reason = $_POST['reason'];

        // Insert initial request without attachment
        $sql = "INSERT INTO tbl_passreset_depaide (reason, attachment) VALUES (:reason, '')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':reason' => $reason]);

        $passreset_id = $conn->lastInsertId();

        // Handle file upload if an attachment is provided
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "asset/uploads/pass_reset/"; 
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }

            $fileType = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

            // Validate file type
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Invalid file format. Only JPG, PNG, and PDF files are allowed.");
            }

            $newFileName = $passreset_id . "." . $fileType;
            $filePath = $targetDir . $newFileName;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload file.");
            }

            // Update the attachment in the database
            $updateSql = "UPDATE tbl_passreset_depaide SET attachment = :attachment WHERE id = :id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->execute([
                ':attachment' => $filePath,
                ':id' => $passreset_id
            ]);
        }

        // Insert request into tbl_request_depaide
        $insertRequestSql = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                             VALUES (:userId, :request_type_id, :request_type_table)";
        $insertRequestStmt = $conn->prepare($insertRequestSql);
        $insertRequestStmt->execute([
            ':userId' => $userId,
            ':request_type_id' => $passreset_id,
            ':request_type_table' => 'password_reset'
        ]);
        $request_id = $conn->lastInsertId();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Request Submitted!',
                        text: 'Your Email Concern request has been recorded successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'status?request_id=".$request_id."';
                    });
                });
              </script>";

    } catch (Exception $e) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '" . addslashes($e->getMessage()) . "',
                        confirmButtonText: 'OK'
                    });
                });
              </script>";
    }
}
?>