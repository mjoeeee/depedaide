<?php
include 'all_function.php';
include 'config.php';

$requestExists = false;
$userDetails = null;


$stmtCheck = $conn->prepare("SELECT * FROM tbl_request_depaide 
                              JOIN tbl_printingid_depaide 
                              ON tbl_request_depaide.request_type_id = tbl_printingid_depaide.id 
                              WHERE tbl_request_depaide.userId = :userId 
                              AND tbl_request_depaide.request_type_table = 'id_card_printing'");
$stmtCheck->execute([':userId' => $_SESSION['userId']]);
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
                fname = :fname, lname = :lname, mname = :mname, ext_name = :ext_name, tin_no = :tin_no,
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
                ':tin_no' => $_POST['tin_no'],
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
                emrgncy_no, emrgncy_name, emrgncy_email, prfx_name, fname, lname, mname, ext_name, tin_no,
                gsis_no, pagibig_no, philhealth_no, blood_type
            ) VALUES (
                :email, :dep_id, :role, :hr_id, :bday, :job_title, :emp_id, :prc_no,
                :emrgncy_no, :emrgncy_name, :emrgncy_email, :prfx_name, :fname, :lname, :mname, :ext_name, :tin_no,
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
                ':tin_no' => $_POST['tin_no'],
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
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
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
                if (!move_uploaded_file($_FILES['sign']['tmp_name'], $signPath)) {
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
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    throw new Exception("Error uploading image.");
                }
            }

            // Handle Signature Upload
            if (!empty($_FILES['sign']['name'])) {
                $signExt = pathinfo($_FILES['sign']['name'], PATHINFO_EXTENSION);
                $signPath = "asset/uploads/print_id/sign/{$userDetails['id']}.{$signExt}";
                if (!move_uploaded_file($_FILES['sign']['tmp_name'], $signPath)) {
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
        }

        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your request for ID card printing has been submitted/updated',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'printing_id_card?t=' + new Date().getTime(); // Bypass cache
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
if (isset($_GET['request_id']) && isset($_GET['id'])) {
    $request_id = $_GET['request_id'];
    $id = $_GET['id'];

    // Connect to database
    $conn = new mysqli("localhost", "username", "password", "database_name");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform cancellation (modify this query according to your logic)
    $sql = "DELETE FROM tbl_printingid_depaide WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $sql2 = "DELETE FROM tbl_request_depaide WHERE request_id = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("i", $request_id);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Cancelled!',
                text: 'The ID card printing request has been canceled.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'printing_id_card'; // Redirect after alert
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'There was a problem canceling the request.',
                icon: 'error'
            }).then(() => {
                window.history.back(); // Go back if there's an error
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Invalid Request!',
            text: 'Missing request ID or user ID.',
            icon: 'warning'
        }).then(() => {
            window.history.back();
        });
    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request ID Card Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_printing_id_card.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
    <a class="navbar-brand" href="dashboard">
            <img src="image/logo (1).png" alt="Logo"> <!-- Replace with your logo path -->
        </a>
        <div class="burger-menu" onclick="toggleSidebar()">
            <div></div>
            <div></div>
            <div></div>
        </div>
>


    </nav>

    <div class="container">

        <div class="sidebar" id="sidebar">
        <div class="profile-container">
        <h3 class="profile-link">
            <i class="fas fa-user-circle me-1"></i>
            <?php echo $_SESSION['fullname']; ?>
        </h3>
    </div>         
    <a href="dashboard" class="status-link">
         <i class="fas fa-chart-line"></i></i> Dashboard
        </a>
            <div class="dropdown" onclick="toggleDropdown(this)">
                <a href="#">
                    <i class="fas fa-file-alt"></i> 
                    Request Forms
                    <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                </a>
                <div class="dropdown-content">
                <a href="printing_id_card" style="font-weight: bold; color:rgb(238, 108, 21);">
                    <i class="fas fa-print"></i>
                    Printing ID Card
                </a>
                <a href="deped_email">
                    <i class="fas fa-envelope"></i> <!-- Icon for Email -->
                    DepEd Email
                </a>
                <a href="password_reset">
                    <i class="fas fa-key"></i> 
                    Email Concern
                </a>  
                <a href="ict_maintenance">
                    <i class="fas fa-desktop"></i> 
                    ICT Maintenance
                </a>
                <a href="documentation">
                    <i class="fas fa-file-alt"></i> 
                    Documentation
                </a>
                <a href="editing_form">
                    <i class="fas fa-video"></i> 
                    Audio Visual Editing
                </a>
                <a href="inspection_form">
                    <i class="fas fa-search"></i> 
                    ICT Equipment Inspection
                </a>
                <a href="software_development">
                    <i class="fas fa-code"></i> 
                    Software Development
                </a>
            </div>
            </div>

            <!-- Status Link (Outside Dropdown) -->
            <a href="status" class="status-link">
                <i class="fas fa-info-circle"></i> Status
            </a>
            <a href="#" onclick="confirmLogout()" title="Logout">
                    <i class="fas fa-power-off"></i> Logout
                </a>
                <script src="asset/js/logout.js"></script>
        </div>


            <div class="form-container" style="margin-top: 30px; margin-right: 5px; padding-top: 50px; width: 90%;">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="profile-and-details">
                <div class="box-body box-profile">
                            <!-- Full Name Display -->
                            <h3 class="profile-username text-center"><?php echo $_SESSION['fullname']; ?></h3>
                            <!-- Profile Picture Upload -->
                            <div class="form-group text-center">
                                <label for="photo"><strong>ID Picture</strong></label>
                                <div id="preview-image" class="preview-image">
                                    <img id="imagePreview" class="profile-user-img img-responsive img-round" 
                                    src="<?php echo ($requestExists ? $userDetails['image'] : 'image/2x2 default.png') . '?t=' . time(); ?>">
                                </div>
                                <input type="file" name="image" id="photo" accept=".jpg,.jpeg" class="btn btn-xs"
                                    onchange="previewFile(this, 'imagePreview', 'jpg')"/>
                                    <small class="text-muted">
                                    <i class="fas fa-info-circle text-primary"></i>JPG/JPEG, 2x2 inches, white background.
                                    </small>
                            </div>

                            <br>

                            <!-- Signature Upload -->
                            <div class="form-group text-center">
                                <label for="signature"><strong>Signature</strong></label>
                                <div id="preview-image1" class="preview-image">
                                    <img id="signPreview" class="profile-user-img img-responsive img-rounded" 
                                    src="<?php echo ($requestExists ? $userDetails['sign'] : 'image/2x2 signature.png') . '?t=' . time(); ?>">
                                </div>
                                <input type="file" name="sign" id="signature" accept=".png" class="btn btn-xs"
                                    onchange="previewFile(this, 'signPreview', 'png')"/>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle text-primary"></i> PNG, 2x2 inches, white background.
                                    </small>


                            </div>

                        <br>


                    </div>

                        <hr>
            <div class="user-details">
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['email'] : $_SESSION['email']); ?>" 
                            required readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label for="departmentId">Department ID</label>
                        <input type="text" name="dep_id" id="departmentId" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['dep_id'] : $_SESSION['department_id']); ?>" 
                            required readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" name="role" id="role" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['role'] : $_SESSION['role']); ?>" 
                            readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                </div>
                <h2>User Details</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="hrId">HR ID</label>
                        <input type="text" id="hrId" name="hr_id" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['hr_id'] : $_SESSION['hrId']); ?>" 
                            readonly required style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <?php
                        $bday = $requestExists ? $userDetails['bday'] : (isset($_SESSION['dob']) ? $_SESSION['dob'] : '');
                    if (!empty($bday)) {
                        $bday = str_replace('/', '-', $bday); 
                    }
                    ?>

                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" id="birthdate" name="bday" 
                            value="<?php echo htmlspecialchars($bday); ?>" required>
                    </div>

                </div>
                <div class="form-row">
                        <div class="form-group">
                            <label for="jobTitle">Job Title</label>
                            <select id="jobTitle" name="job_title" class="form-control" required>
                                <option value="">Select Job Title</option>
                                <?php

                                try {
                                    // Fetch all unique job titles from the database
                                    $stmt = $conn->prepare("SELECT DISTINCT job_title FROM tbl_user WHERE job_title IS NOT NULL AND job_title != '' ORDER BY job_title ASC");
                                    $stmt->execute();
                                    $jobTitles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($jobTitles as $row) {
                                        $jobTitle = htmlspecialchars($row['job_title']);
                                        // Check if the user has submitted a request or use the session variable
                                        $selected = ($jobTitle === ($requestExists ? $userDetails['job_title'] : $_SESSION['job_title'])) ? 'selected' : '';
                                        echo "<option value=\"$jobTitle\" $selected>$jobTitle</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo '<option disabled>Error fetching job titles</option>';
                                }
                                ?>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="employeeId">Employee ID</label>
                        <input type="text" id="employeeId" name="emp_id" 
                        value="<?php echo htmlspecialchars($requestExists ? $userDetails['hr_id'] : $_SESSION['employee_id']); ?>" 
                            required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="fname" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['fname'] : $_SESSION['firstname']); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middleName" name="mname" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['mname'] : $_SESSION['middlename']); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lname" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['lname'] : $_SESSION['lastname']); ?>" 
                            required>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group">
                    <label for="prefixName">Prefix Name</label>
                    <select id="prefixName" name="prfx_name" required>
                        <option value="">Select Prefix</option>
                        <?php
                        $selectedPrefix = $requestExists && !empty($userDetails['prfx_name']) ? $userDetails['prfx_name'] : (isset($_SESSION['prefix_name']) ? $_SESSION['prefix_name'] : '');

                        $prefixOptions = ["Mr.", "Ms.", "Mrs.", "Dr.", "Engr.", "Prof.", "Atty.", "Hon.", "Rev."];

                        foreach ($prefixOptions as $prefix) {
                            $selected = ($selectedPrefix == $prefix) ? 'selected' : '';
                            echo "<option value=\"$prefix\" $selected>$prefix</option>";
                        }
                        ?>
                    </select>
                </div>

                    <div class="form-group">
                        <label for="extensionName">Extension Name</label>
                        <select id="extensionName" name="ext_name">
                            <option value="">Select Extension Name</option>
                            <?php
                            $selectedExt = $requestExists && !empty($userDetails['ext_name']) ? $userDetails['ext_name'] : (isset($_SESSION['extname']) ? $_SESSION['extname'] : '');

                            $extensions = ["Jr.", "Sr.", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "Esq.", "MD", "PhD", "DDS", "DMD", "JD"];

                            foreach ($extensions as $ext) {
                                $selected = ($selectedExt == $ext) ? 'selected' : '';
                                echo "<option value=\"$ext\" $selected>$ext</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="form-row">
                        <div class="form-group">
                            <label for="prcNo">PRC No.</label>
                            <input type="text" id="prcNo" name="prc_no" 
                                value="<?php echo htmlspecialchars($requestExists && !empty($userDetails['prc_no']) ? $userDetails['prc_no'] : (isset($_SESSION['prc_no']) ? $_SESSION['prc_no'] : '')); ?>" 
                                required>
                        </div>
                        <div class="form-group">
                            <label for="tinNo">TIN No.</label>
                            <input type="text" id="tinNo" name="tin_no" 
                                value="<?php echo htmlspecialchars($requestExists && !empty($userDetails['tin_no']) ? $userDetails['tin_no'] : (isset($_SESSION['tin']) ? $_SESSION['tin'] : '')); ?>" 
                                required>
                        </div>
                        <div class="form-group">
                            <label for="gsisNo">GSIS No.</label>
                            <input type="text" id="gsisNo" name="gsis_no" 
                                value="<?php echo htmlspecialchars($requestExists && !empty($userDetails['gsis_no']) ? $userDetails['gsis_no'] : (isset($_SESSION['gsis']) ? $_SESSION['gsis'] : '')); ?>" 
                                required>
                        </div>
                </div>
                <div class="form-row">
                        <div class="form-group">
                            <label for="pagibigNo">Pag-IBIG No.</label>
                            <input type="text" id="pagibigNo" name="pagibig_no" 
                                value="<?php echo htmlspecialchars($requestExists && !empty($userDetails['pagibig_no']) ? $userDetails['pagibig_no'] : (isset($_SESSION['pag_ibig']) ? $_SESSION['pag_ibig'] : '')); ?>" 
                                required>
                        </div>
                        <div class="form-group">
                            <label for="philhealthNo">PhilHealth No.</label>
                            <input type="text" id="philhealthNo" name="philhealth_no" 
                                value="<?php echo htmlspecialchars($requestExists && !empty($userDetails['philhealth_no']) ? $userDetails['philhealth_no'] : (isset($_SESSION['philhealth']) ? $_SESSION['philhealth'] : '')); ?>" 
                                required>
                        </div>
                    <div class="form-group">
                        <label for="bloodType">Blood Type</label>
                        <select id="bloodType" name="blood_type" class="form-control" required>
                            <option value="" selected disabled>Select Blood Type</option>
                            <?php
                            $bloodTypes = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
                            $selectedBloodType = $requestExists && !empty($userDetails['blood_type']) ? $userDetails['blood_type'] : (isset($_SESSION['blood_type']) ? $_SESSION['blood_type'] : '');
                            
                            foreach ($bloodTypes as $type) {
                                $selected = ($selectedBloodType == $type) ? 'selected' : '';
                                echo "<option value=\"$type\" $selected>$type</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <label for="prcNo">In case of emergency</label>
                <div class="form-row">
                    <div class="form-group">
                        <label for="emrgncy_no">Contact No.</label>
                        <input type="text" id="emrgncy_no" name="emrgncy_no" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['emrgncy_no'] : ''); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="emrgncy_name">Name</label>
                        <input type="text" id="emrgncy_name" name="emrgncy_name" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['emrgncy_name'] : ''); ?>" 
                            required> 
                    </div>
                    <div class="form-group">
                        <label for="emrgncy_email">Email</label>
                        <input type="email" id="emrgncy_email" name="emrgncy_email" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['emrgncy_email'] : ''); ?>" 
                            required>
                            <input type="hidden" id="request_id" value="<?php echo $request_id; ?>">
                            <input type="hidden" id="id" value="<?php echo $id; ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="cancel" onclick="clearFields()">Clear Fields</button>
            <?php if ($requestExists): ?>
                <button type="submit" class="apply">Update Details</button>

            <?php else: ?>
                <button type="submit" class="apply">Submit Request</button>
            <?php endif; ?>
        </div>
    </div>
</form>
<script src="asset/js/toggle_navbar.js"></script>
<script>
        function clearFields() {
            document.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], select').forEach(input => {
                // Exclude specific fields from being cleared
                if (!['email', 'departmentId', 'role', 'hrId'].includes(input.id)) {
                    input.value = '';
                }
            });
        }

        function previewFile(input, previewId, type) {
                        let file = input.files[0];

                        if (file) {
                            let fileType = file.name.split('.').pop().toLowerCase();
                            if ((type === 'jpg' && (fileType !== 'jpg' && fileType !== 'jpeg')) || (type === 'png' && fileType !== 'png')) {
                                alert('Invalid file type. Only ' + type.toUpperCase() + ' files are allowed.');
                                input.value = ''; // Clear the input field
                                return;
                            }

                            let reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById(previewId).src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }

            document.addEventListener("DOMContentLoaded", function () {
                // Select all input fields that should allow only numbers and dashes
                const numericInputs = document.querySelectorAll("#prcNo, #tinNo, #gsisNo, #pagibigNo, #philhealthNo,#employeeId");

                numericInputs.forEach(input => {
                    input.addEventListener("input", function () {
                        this.value = this.value.replace(/[^0-9-]/g, ""); // Allow only numbers and dashes
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const contactInput = document.getElementById("emrgncy_no");

                contactInput.addEventListener("input", function () {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/\D/g, "");

                    // Ensure it starts with '09'
                    if (!this.value.startsWith("09")) {
                        this.value = "09";
                    }

                    // Restrict input to exactly 11 digits
                    if (this.value.length > 11) {
                        this.value = this.value.slice(0, 11);
                    }
                });

            contactInput.addEventListener("blur", function () {
                if (this.value.length !== 11) {
                    Swal.fire({
                        icon: "warning",
                        title: "Invalid Contact Number",
                        text: "Contact number must be exactly 11 digits.",
                        confirmButtonColor: "#d33"
                    }).then(() => {
                        this.focus();
                    });
                }
            });
        });

            document.addEventListener("DOMContentLoaded", function () {
                const birthdateInput = document.getElementById("birthdate");

                // Function to calculate the date 18 years ago from today
                function getMinDate() {
                    const today = new Date();
                    const minDate = new Date(today.setFullYear(today.getFullYear() - 18));
                    return minDate.toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
                }

                // Set the minimum date to be 18 years ago
                birthdateInput.setAttribute("max", getMinDate());
            });
</script>


</body>
</html>