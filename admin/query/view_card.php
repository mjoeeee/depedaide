<?php
$requestExists = false;
$userDetails = null;
$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : null;

// Check if the user has already made a request or uploaded details
$stmtCheck = $conn->prepare("SELECT * FROM tbl_request_depaide 
                              JOIN tbl_printingid_depaide 
                              ON tbl_request_depaide.request_type_id = tbl_printingid_depaide.id 
                              JOIN tbl_user 
                              ON tbl_request_depaide.userId = tbl_user.userId 
                              WHERE tbl_request_depaide.request_id = :request_id 
                              AND tbl_request_depaide.request_type_table = 'id_card_printing'");
$stmtCheck->execute([':request_id' => $request_id]);
$userDetails = $stmtCheck->fetch(PDO::FETCH_ASSOC);

if ($userDetails) {
    $requestExists = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Update existing details if the user has already submitted
        if ($requestExists) {
            $stmt = $conn->prepare("UPDATE tbl_printingid_depaide SET 
                email = :email, dep_id = :dep_id, role = :role, hr_id = :hr_id, 
                bday = :bday, job_title = :job_title, emp_id = :emp_id, prc_no = :prc_no,
                emrgncy_no = :emrgncy_no, emrgncy_name = :emrgncy_name, 
                emrgncy_email = :emrgncy_email, prfx_name = :prfx_name, 
                fname = :fname, lname = :lname, mname = :mname, ext_name = :ext_name,
                gsis_no = :gsis_no, pagibig_no = :pagibig_no, 
                philhealth_no = :philhealth_no, blood_type = :blood_type
            WHERE id = :id");

            $stmt->execute([
                ':email' => $_POST['email'],
                ':dep_id' => $_POST['dep_id'],
                ':role' => $_POST['role'],
                ':hr_id' => $_POST['hr_id'],
                ':bday' => $_POST['bday'],
                ':job_title' => $_POST['job_title'],
                ':emp_id' => $_POST['emp_id'],
                ':prc_no' => $_POST['prc_no'],
                ':emrgncy_no' => $_POST['emrgncy_no'],
                ':emrgncy_name' => $_POST['emrgncy_name'],
                ':emrgncy_email' => $_POST['emrgncy_email'],
                ':prfx_name' => $_POST['prfx_name'],
                ':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':mname' => $_POST['mname'],
                ':ext_name' => $_POST['ext_name'],
                ':gsis_no' => $_POST['gsis_no'],
                ':pagibig_no' => $_POST['pagibig_no'],
                ':philhealth_no' => $_POST['philhealth_no'],
                ':blood_type' => $_POST['blood_type'],
                ':id' => $userDetails['id'] // Use the existing ID for update
            ]);
        } else {
            // Insert new request logic here
            $stmt = $conn->prepare("INSERT INTO tbl_printingid_depaide (
                email, dep_id, role, hr_id, bday, job_title, emp_id, prc_no,
                emrgncy_no, emrgncy_name, emrgncy_email, prfx_name, fname, lname, mname, ext_name,
                gsis_no, pagibig_no, philhealth_no, blood_type
            ) VALUES (
                :email, :dep_id, :role, :hr_id, :bday, :job_title, :emp_id, :prc_no,
                :emrgncy_no, :emrgncy_name, :emrgncy_email, :prfx_name, :fname, :lname, :mname, :ext_name,
                :gsis_no, :pagibig_no, :philhealth_no, :blood_type
            )");

            $stmt->execute([
                ':email' => $_POST['email'],
                ':dep_id' => $_POST['dep_id'],
                ':role' => $_POST['role'],
                ':hr_id' => $_POST['hr_id'],
                ':bday' => $_POST['bday'],
                ':job_title' => $_POST['job_title'],
                ':emp_id' => $_POST['emp_id'],
                ':prc_no' => $_POST['prc_no'],
                ':emrgncy_no' => $_POST['emrgncy_no'],
                ':emrgncy_name' => $_POST['emrgncy_name'],
                ':emrgncy_email' => $_POST['emrgncy_email'],
                ':prfx_name' => $_POST['prfx_name'],
                ':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':mname' => $_POST['mname'],
                ':ext_name' => $_POST['ext_name'],
                ':gsis_no' => $_POST['gsis_no'],
                ':pagibig_no' => $_POST['pagibig_no'],
                ':philhealth_no' => $_POST['philhealth_no'],
                ':blood_type' => $_POST['blood_type']
            ]);

            $lastId = $conn->lastInsertId();

            // Handle Image Upload
            if (!empty($_FILES['image']['name'])) {
                $imageExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imagePath = "asset/uploads/print_id/image/{$lastId}.{$imageExt}";
                if (!move_uploaded_file($_FILES['image']['tmp_name'],"../" .$imagePath)) {
                    throw new Exception("Error uploading image.");
                }

                // Update the image path in the database
                $stmt = $conn->prepare("UPDATE tbl_printingid_depaide SET image = :image WHERE id = :id");
                $stmt->execute([
                    ':image' => $imagePath,
                    ':id' => $lastId
                ]);
            }

            // Handle Signature Upload
            if (!empty($_FILES['sign']['name'])) {
                $signExt = pathinfo($_FILES['sign']['name'], PATHINFO_EXTENSION);
                $signPath = "asset/uploads/print_id/sign/{$lastId}.{$signExt}";
                if (!move_uploaded_file($_FILES['sign']['tmp_name'],"../" . $signPath)) {
                    throw new Exception("Error uploading signature.");
                }

                // Update the sign path in the database
                $stmt = $conn->prepare("UPDATE tbl_printingid_depaide SET sign = :sign WHERE id = :id");
                $stmt->execute([
                    ':sign' => $signPath,
                    ':id' => $lastId
                ]);
            }
        }

        // Handle Image and Signature Upload for Updates
        if ($requestExists) {
            $imagePath = $userDetails['image'];
            $signPath = $userDetails['sign'];

            // Handle Image Upload
            if (!empty($_FILES['image']['name'])) {
                $imageExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imagePath = "asset/uploads/print_id/image/{$userDetails['id']}.{$imageExt}";
                if (!move_uploaded_file($_FILES['image']['tmp_name'],"../" . $imagePath)) {
                    throw new Exception("Error uploading image.");
                }
            }

            // Handle Signature Upload
            if (!empty($_FILES['sign']['name'])) {
                $signExt = pathinfo($_FILES['sign']['name'], PATHINFO_EXTENSION);
                $signPath = "asset/uploads/print_id/sign/{$userDetails['id']}.{$signExt}";
                if (!move_uploaded_file($_FILES['sign']['tmp_name'],"../" .$signPath)) {
                    throw new Exception("Error uploading signature.");
                }
            }

            // Update image and sign paths
            $stmt = $conn->prepare("UPDATE tbl_printingid_depaide SET image = :image, sign = :sign WHERE id = :id");
            $stmt->execute([
                ':image' => $imagePath,
                ':sign' => $signPath,
                ':id' => $userDetails['id']
            ]);
        }

        // Insert into tbl_request_depaide if it's a new request
        if (!$requestExists) {
            $stmt2 = $conn->prepare("INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                                     VALUES (:userId, :request_type_id, :request_type_table)");
            $stmt2->execute([
                ':userId' => $_SESSION['userId'],
                ':request_type_id' => $lastId,
                ':request_type_table' => 'id_card_printing'
            ]);
                    
            // Get the last inserted request_id
            $request_id = $conn->lastInsertId();
        }else{
            // If updating, use the existing request_id
            $request_id = $userDetails['request_id'];
        }

        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your request for ID card printing has been submitted/updated',
                confirmButtonText: 'OK'
            }).then(() => {
    window.location.href = 'view_card?request_id={$request_id}&t=' + new Date().getTime();
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