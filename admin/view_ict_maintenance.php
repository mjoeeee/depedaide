<?php       
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/view_ict_maintenance.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Maintenance Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_view_ict_maintenance.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-custom">
        <a class="navbar-brand" href="dashboard">
            <img src="../image/logo (1).png" alt="Logo">
        </a>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Card with Breadcrumb -->
        <div class="header-card">
            <div class="breadcrumb">
                <span class="separator"></span>
                <a href="ict_maintenance">Go back</a>
                <span class="separator">/</span>
                <span>Request Form</span>
            </div>
        </div>

 <!-- Form Container -->
<div class="form-container">
    <h3>ICT TECHNICAL ASSISTANCE FORM</h3>
    <hr style="height: 5px; background-color: black; border: none;">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <!-- Hidden Input for Request ID -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'] ? $result['id'] : '') ?>">

        <table>
            <tr>
                <th colspan="2">I</th>
            </tr>
            <tr>
            <input type="hidden" name="request_id" value="<?= htmlspecialchars($result['request_id'] ? $result['request_id'] : '') ?>">

                <td>Control Number</td>
                <td><input type="text" name="controlNumber" value="<?= htmlspecialchars($result['request_id'] ? $result['request_id'] : '') ?>" readonly style="background-color: #f0f0f0; cursor: not-allowed;"></td>

            </tr>
            <tr>
                <td>Date:</td>
                <td><input type="date" name="date" value="<?= htmlspecialchars($result['date_current'] ? $result['date_current'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Time:</td>
                <td><input type="time" name="time" value="<?= htmlspecialchars($result['time_current'] ? $result['time_current'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Requested by:</td>
                <td>
                    Name: <input type="text" name="name" value="<?= htmlspecialchars($result['req_name'] ? $result['req_name'] : '') ?>"><br>
                    Designation: <input type="text" name="designation" value="<?= htmlspecialchars($result['req_designation'] ? $result['req_designation'] : '') ?>"><br>
                    Division Office: <br>
                    <select name="divisionOffice">
                    <option value="">Select Office</option>
                    <?php
                    $offices = [
                        "Guest",
                        "Regional/Central Office",
                        "OSDS/SDS Office",
                        "OSDS/ASDS Office",
                        "OSDS/Admin Office",
                        "OSDS/Accounting Office",
                        "OSDS/Legal Unit",
                        "OSDS/ICT Unit",
                        "SGOD Office",
                        "CID Office",
                        "CID/LRMDS Office",
                        "BAC Secretariat",
                        "School Personnel Group",
                        "Admin/Records Office",
                        "Admin/Supply Office",
                        "Admin/Cashiering Office",
                        "Admin/Personnel",
                        "SGOD/M & E",
                        "SGOD/Planning",
                        "SGOD/SocMob",
                        "SGOD/HRLD",
                        "SGOD/Health & Nutrition",
                        "SGOD/Youth Formation",
                        "SGOD/Educational Facilities",
                        "SGOD/Budget Office",
                        "CID/ALS"
                    ];

                    $selectedOffice = htmlspecialchars($result['req_DO'] ?? ''); // Get selected value safely

                    foreach ($offices as $office) {
                        $selected = ($office === $selectedOffice) ? 'selected' : ''; // Auto-select if it matches
                        echo "<option value='$office' $selected>$office</option>";
                    }
                    ?>
                </select>   
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th colspan="2">II</th>
            </tr>
            <tr>
                <td>Description of Property/Equipment:</td>
                <td width="69%"><input type="text" name="propertyDescription" value="<?= htmlspecialchars($result['DOPE'] ? $result['DOPE'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Brand:</td>
                <td><input type="text" name="brand" value="<?= htmlspecialchars($result['brand'] ? $result['brand'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Property No.:</td>
                <td><input type="text" name="propertyNumber" value="<?= htmlspecialchars($result['prop_no'] ? $result['prop_no'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Serial/Engine No.:</td>
                <td><input type="text" name="serialNumber" value="<?= htmlspecialchars($result['serial_no'] ? $result['serial_no'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Defects/Complaints:</td>
                <td><textarea name="defects" rows="4"><?= htmlspecialchars($result['serial_no'] ? $result['serial_no'] : '') ?></textarea></td>
            </tr>
        </table>

        <table>
            <tr>
                <th colspan="2">III</th>
            </tr>
            <tr>
                <td>Date Inspected:</td>
                <td width="69%"><input type="datetime-local" name="inspectionDate" value="<?= htmlspecialchars($result['date_inspected'] ? $result['date_inspected'] : '') ?>"></td>
            </tr>
            <tr>
                <td>Identified Problem/Issues:</td>
                <td><textarea name="identifiedProblems" rows="4"><?= htmlspecialchars($result['IPI'] ? $result['IPI'] : '') ?></textarea></td>
            </tr>
            <tr>
                <td>Description of Technical Support:</td>
                <td><textarea name="technicalSupport"  rows="4"><?= htmlspecialchars($result['DTS'] ? $result['DTS'] : '') ?></textarea></td>
            </tr>
            <tr>
                <td>Recommendation/s:</td>
                <td><textarea name="recommendations" rows="4"><?= htmlspecialchars($result['recomend'] ? $result['recomend'] : '') ?></textarea></td>
            </tr>
        </table>

        <!-- Buttons Section -->
        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Details</button>
            <a href="ict_maintenance" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
<?php if (isset($_GET['update']) && $_GET['update'] == "success"): ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Updated Successfully!",
            text: "The record has been updated.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == "invalid_request"): ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Update Failed!",
            text: "Something went wrong. Please try again.",
            showConfirmButton: true
        });
    </script>
<?php endif; ?>

    </div>
</body>
</html>