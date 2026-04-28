<?php
// include 'query/view_software_request.php';

try {
    // Get and sanitize request_id
    $request_id = filter_input(INPUT_GET, 'request_id', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query using a placeholder
    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_passreset_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'password_reset' AND r.request_id = ?
                          ");
    $stmt->execute([$request_id]);


    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $request_id = filter_var($_POST['request_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $reason = htmlspecialchars($_POST['reason']);



    // Fetch the existing attachment filename
    $stmt = $conn->prepare("SELECT attachment FROM tbl_passreset_depaide WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingAttachment = isset($result['attachment']) ? $result['attachment'] : '';


    // Define upload directory
    $uploadDir = 'asset/uploads/pass_reset/';
    $attachment = $existingAttachment; // Default to the existing attachment

    if (!empty($_FILES['attachment']['name']) && !empty($existingAttachment)) {
        // Keep the old attachment's file name
        $fileName = basename($existingAttachment);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];

        if (in_array($fileType, $allowedTypes)) {
            // Ensure upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the uploaded file, overwriting the old one
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
                $attachment = $targetFilePath;
            } else {
                die("File upload failed.");
            }
        } else {
            die("Invalid file type.");
        }
    }

    try {
        // Update the database with the existing attachment name
        $stmt2 = $conn->prepare("UPDATE tbl_passreset_depaide 
                                 SET reason = ?
                                WHERE id = ?");
        $stmt2->execute([$reason, $id]);

        // Redirect after success
        header("Location: view_email_concern?update=success&request_id=$request_id");
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}

?>