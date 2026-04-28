<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // ✅ Check if the user already has a request
        $sql_check = "SELECT stat,request_id FROM tbl_request_depaide WHERE userId = :userId AND request_type_table = 'deped_email_request'";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([':userId' => $_SESSION['userId']]);
        $existing_request = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_request) {
            $request_id = $existing_request['request_id'];
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'info',
                            title: 'Request Already Submitted',
                            text: 'Current Status: {$existing_request['stat']}',
                            confirmButtonText: 'OK'
                        }).then(() => {
                        window.location.href = 'status?request_id=" . $request_id . "';
                        });
                    });
                  </script>";
        } else {
            // ✅ Proceed with inserting the request if no existing request
            $conn->beginTransaction();

            $sql1 = "INSERT INTO tbl_depedemail_depaide 
                        (school_id, email_format) 
                     VALUES (:school_id, :email_format)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([
                ':school_id' => $_POST['officeId'],
                ':email_format' => $_POST['email_format']
            ]);

            $maintenance_id = $conn->lastInsertId();

            $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                     VALUES (:userId, :request_type_id, :request_type_table)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([
                ':userId' => $_SESSION['userId'],
                ':request_type_id' => $maintenance_id,
                ':request_type_table' => 'deped_email_request'
            ]);
            $request_id = $conn->lastInsertId();
            $conn->commit();
    
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Submitted!',
                            text: 'Your ICT Maintenance request has been recorded successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'status?request_id=" . $request_id . "';
                        });
                    });
                  </script>";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
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