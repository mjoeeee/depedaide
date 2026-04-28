<?php
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/view_card.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_view_card.css">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <a class="navbar-brand" href="dashboard">
            <img src="../image/logo (1).png" alt="Logo"> <!-- Replace with your logo path -->
        </a>
    </nav>

    <!-- Breadcrumb Navigation -->
    <div class="header-card">
            <div class="breadcrumb">
                <span class="separator"></span>
                <a href="id_card">Go back</a>
                <span class="separator">/</span>
                <span>Request Form</span>
    </div>
    </div>
    <!-- Form Container -->
    <div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
                <div class="profile-and-details">
                <div class="box-body box-profile">
                            <!-- Full Name Display -->
                            <h3 class="profile-username text-center"><?php echo $userDetails['fullname'] ?></h3>
                            <!-- Profile Picture Upload -->
                            <div class="form-group text-center">
                                <label for="photo"><strong>ID Picture</strong></label>
                                <div id="preview-image" class="preview-image">
                                <img id="imagePreview" class="profile-user-img img-responsive img-round" 
                                src="../<?php echo $requestExists ? $userDetails['image'] : '../image/2x2 default.png'; ?>?t=<?php echo time(); ?>">
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
                                src="../<?php echo $requestExists ? $userDetails['sign'] : '../image/2x2 signature.png'; ?>?t=<?php echo time(); ?>">
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
                            value="<?php echo htmlspecialchars($userDetails['email']); ?>" 
                            required readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label for="departmentId">Department ID</label>
                        <input type="text" name="dep_id" id="departmentId" 
                            value="<?php echo htmlspecialchars($userDetails['dep_id']); ?>" 
                            required readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" name="role" id="role" 
                            value="<?php echo htmlspecialchars($userDetails['role']); ?>" 
                            readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                </div>
                <h2>User Details</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="hrId">HR ID</label>
                        <input type="text" id="hrId" name="hr_id" 
                            value="<?php echo htmlspecialchars($userDetails['hr_id']); ?>" 
                            readonly required style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" id="birthdate" name="bday" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['bday'] : ''); ?>" 
                            required>
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
                                        // Check if the user has submitted a request
                                        $selected = ($jobTitle === ($requestExists ? $userDetails['job_title'] : '')) ? 'selected' : '';
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
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['emp_id'] : ''); ?>" 
                            required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="fname" 
                            value="<?php echo htmlspecialchars($userDetails['fname']); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middleName" name="mname" 
                            value="<?php echo htmlspecialchars($userDetails['mname']); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lname" 
                            value="<?php echo htmlspecialchars($userDetails['lname'] ); ?>" 
                            required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="prefixName">Prefix Name</label>
                        <select id="prefixName" name="prfx_name" required>
                            <option value="">Select Prefix</option>
                            <option value="Mr." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                            <option value="Ms." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Ms.') ? 'selected' : ''; ?>>Ms.</option>
                            <option value="Mrs." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Mrs.') ? 'selected' : ''; ?>>Mrs.</option>
                            <option value="Dr." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Dr.') ? 'selected' : ''; ?>>Dr.</option>
                            <option value="Engr." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Engr.') ? 'selected' : ''; ?>>Engr.</option>
                            <option value="Prof." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Prof.') ? 'selected' : ''; ?>>Prof.</option>
                            <option value="Atty." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Atty.') ? 'selected' : ''; ?>>Atty.</option>
                            <option value="Hon." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Hon.') ? 'selected' : ''; ?>>Hon.</option>
                            <option value="Rev." <?php echo ($requestExists && $userDetails['prfx_name'] == 'Rev.') ? 'selected' : ''; ?>>Rev.</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="extensionName">Extension Name</label>
                        <select id="extensionName" name="ext_name">
                            <option value="">Select Extension Name</option>
                            <?php
                            $extensions = ["Jr.", "Sr.", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "Esq.", "MD", "PhD", "DDS", "DMD", "JD"];
                            foreach ($extensions as $ext) {
                                // Check if the user has submitted a request
                                $selected = ($requestExists && isset($userDetails['ext_name']) && $userDetails['ext_name'] == $ext) ? 'selected' : '';
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
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['prc_no'] : ''); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="gsisNo">GSIS No.</label>
                        <input type="text" id="gsisNo" name="gsis_no" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['gsis_no'] : ''); ?>" 
                            required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="pagibigNo">Pag-IBIG No.</label>
                        <input type="text" id="pagibigNo" name="pagibig_no" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['pagibig_no'] : ''); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="philhealthNo">PhilHealth No.</label>
                        <input type="text" id="philhealthNo" name="philhealth_no" 
                            value="<?php echo htmlspecialchars($requestExists ? $userDetails['philhealth_no'] : ''); ?>" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="bloodType">Blood Type</label>
                        <select id="bloodType" name="blood_type" class="form-control" required>
                            <option value="" selected disabled>Select Blood Type</option>
                            <option value="A+" <?php echo ($requestExists && $userDetails['blood_type'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo ($requestExists && $userDetails['blood_type'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo ($requestExists && $userDetails['blood_type'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo ($requestExists && $userDetails['blood_type'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo ($requestExists && $userDetails['blood_type'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo ($requestExists && $userDetails['blood_type'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo ($requestExists && $userDetails['blood_type'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo ($requestExists && $userDetails['blood_type'] == 'O-') ? 'selected' : ''; ?>>O-</option>
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
</script>
</body>
</html>