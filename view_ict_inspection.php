<?php       
include 'all_function.php';
include 'config.php';
include 'admin/query/view_ict_inspection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Equipment Inspection Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/admin_view_ict_inspection.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="image/logo (1).png" alt="Logo"> <!-- Replace with your logo path -->
        </a>
    </nav>

    <!-- Header Card with Breadcrumb -->
    <div class="header-card">
            <div class="breadcrumb">
                <span class="separator"></span>
                <a href="status">Go back</a>
                <span class="separator">/</span>
                <span>Request Form</span>
            </div>
        <h1>ICT Equipment Inspection Form</h1>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form action="" method="POST">
        <h3 style="color:rgb(99, 99, 99); font-weight: bold; display: flex; align-items: center;">
            REQUEST FOR INSPECTION
            <span style="flex-grow: 1; border-bottom: 2px dashed rgb(99, 99, 99); margin-left: 10px;"></span>
        </h3>
        <table class="form-table">
            <thead>
                <tr>
                    <th>Item/Description</th>
                    <th>Property Number</th>
                    <th>Property Acknowledgement Receipt No.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'] ? $result['id'] : '') ?>">
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($result['request_id'] ? $result['request_id'] : '') ?>">
                    <td><input type="text" name="item" value="<?= htmlspecialchars($result['item'] ? $result['item'] : '') ?>" placeholder="Item/Description"></td>
                    <td><input type="text" name="property_no" value="<?= htmlspecialchars($result['property_no'] ? $result['property_no'] : '') ?>" placeholder="Property Number"></td>
                    <td><input type="text" name="receipt_no" value="<?= htmlspecialchars($result['receipt_no'] ? $result['receipt_no'] : '') ?>" placeholder="Property Acknowledgement Receipt No."></td>
                </tr>
            </tbody>
        </table>

        <!-- Acquisition Cost and Acquisition Date -->
        <div class="form-row">
            <div class="form-group">
                <label for="acquisitionCost">Acquisition Cost</label>
                <input type="text" id="acquisitionCost" name="acquisition_cost" value="<?= htmlspecialchars($result['acquisition_cost'] ? $result['acquisition_cost'] : '') ?>" placeholder="Enter Acquisition Cost">
            </div>
            <div class="form-group">
                <label for="acquisitionDate">Acquisition Date</label>
                <input type="date" id="acquisitionDate" name="acquisition_date" value="<?= htmlspecialchars($result['acquisition_date'] ? $result['acquisition_date'] :'') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="complaints">Complaints</label>
                <textarea id="complaints" rows="6" name="complaints" placeholder="Enter Complaints"><?= htmlspecialchars($result['complaints'] ? $result['complaints'] : '')?></textarea>
            </div>
            <div class="form-group">
                <label for="lastRepair">Nature and Scope of Last Repair, if any</label>
                <textarea id="lastRepair" rows="6" name="scope_last_repair" placeholder="Enter Nature and Scope of Last Repair"><?= htmlspecialchars($result['scope_last_repair'] ? $result['scope_last_repair'] : '')?></textarea>
            </div>
        </div>
        <h3 style="color: #007bff; font-weight: bold; display: flex; align-items: center;">
 
        <!-- Buttons Section -->
        <div class="d-flex justify-content-end gap-2 mt-3 w-100">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Details</button>
            <a href="status" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
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
</body>
</html>