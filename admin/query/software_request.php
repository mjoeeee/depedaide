<?php
require '../asset/phpmailer/src/Exception.php';
require '../asset/phpmailer/src/PHPMailer.php';
require '../asset/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$requestTypeMap = array(
    'ict_maintenance' => 'ICT Maintenance',
    'software_development' => 'Software Development',
    'ict_equipment_inspection' => 'ICT Equipment Inspection',
    'documentation' => 'Documentation',
    'audio_visual_editing' => 'Audio Visual Editing',
    'deped_email_request' => 'DepEd Email',
    'password_reset' => 'Email Concern',
    'id_card_printing' => 'ID Card Printing',
);
try {

    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_softdev_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'software_development'
                            ORDER BY r.updated_at DESC
                          ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["status"])) {
    $request_id = $_POST['request_id'];
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    try {
        $stmt = $conn->prepare("SELECT u.email, u.lastname, r.request_type_table
                                FROM tbl_user u
                                JOIN tbl_request_depaide r ON u.userId = r.userId
                                WHERE r.request_id = ?");
        $stmt->execute([$request_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_email = $user['email'];
            $lastname = $user['lastname'];
            $request_type_table = $user['request_type_table'];
            $request_type_name = isset($requestTypeMap[$request_type_table]) ? $requestTypeMap[$request_type_table] : 'Unknown Request Type';

            $stmt = $conn->prepare("UPDATE tbl_request_depaide SET stat = ?, remarks = ? WHERE request_id = ?");
            $stmt->execute([$status, $remarks, $request_id]);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'deped1miz@gmail.com'; 
                $mail->Password = 'pkeyuriyjrsgwzpd'; 
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('misdeped1@gmail.com', 'DepAIDE Notification');
                $mail->addAddress($user_email);
                $mail->isHTML(true);
                $mail->Subject = "Request Status Updated";
                $mail->Body = "<p>Dear $lastname,</p>
                               <p>Your request (ID: $request_id) has been updated.</p>
                               <p><strong>Request Type:</strong> $request_type_name</p>
                               <p><strong>Status:</strong> $status</p>
                               <p><strong>Remarks:</strong> $remarks</p>
                               <p>Thank you!</p>           
                               <p style='margin-top: 20px;'>
                                <a href='https://ozamiz.deped.gov.ph/depaide/login' 
                                style='display: inline-block; padding: 10px 20px; font-size: 16px; 
                                        color: white; background-color: #007BFF; text-decoration: none; 
                                        border-radius: 5px; font-weight: bold;'>
                                    Visit Website
                                </a>
                            </p>";
                                    

                $mail->send();
            } catch (Exception $e) {
                echo json_encode(["success" => false, "error" => "Mail Error: " . $mail->ErrorInfo]);
                exit;
            }
        }

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }


} if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idd"])) {
    $request_id = $_POST['request_id'];
    $idd = $_POST['idd'];

    try {
        ob_clean();
        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT attachment FROM tbl_softdev_depaide WHERE id = ?");
        $stmt->execute([$idd]);
        $fileData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fileData && !empty($fileData['attachment'])) {
            $attachmentPath = "../" . $fileData['attachment']; 

            if (file_exists($attachmentPath)) {
                unlink($attachmentPath);
            }
        }

        $stmt = $conn->prepare("DELETE FROM tbl_request_depaide WHERE request_id = ?");
        $stmt->execute([$request_id]);

        $stmt = $conn->prepare("DELETE FROM tbl_softdev_depaide WHERE id = ?");
        $stmt->execute([$idd]);

        $conn->commit();

        echo json_encode(["success" => true]);
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
        exit;
    }
}

?>