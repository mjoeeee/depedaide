
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'all_function.php';
include 'config.php';
include 'query/inspection_form.php';

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_inspection_form.css">
    <style>

    </style>
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


    </nav>

<!-- Container for Sidebar and Content -->
<div class="container">
     <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="profile-container">
                    <h3 class="profile-link">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo $_SESSION['fullname']; ?>
                    </h3>
                </div>
        <a href="dashboard" class="status-link" style="font-weight: bold; color:rgb(238, 108, 21);">
         <i class="fas fa-chart-line"></i></i> Dashboard
        </a>
                <!-- Dropdown -->
            <div class="dropdown" onclick="toggleDropdown(this)">
                    <a href="#">
                        <i class="fas fa-file-alt"></i> 
                        Request Forms
                        <i class="fas fa-chevron-down" style="margin-left: auto;"></i> 
                    </a>
                    <div class="dropdown-content">
                    <!--a href="printing_id_card">
                        <i class="fas fa-print"></i> 
                        Printing ID Card
                    </a-->
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
                    <!--a href="documentation">
                        <i class="fas fa-file-alt"></i> 
                        Documentation
                    </a>
                    <a href="editing_form">
                        <i class="fas fa-video"></i> 
                        Audio Visual Editing
                    </a-->
                    <a href="inspection_form">
                        <i class="fas fa-search"></i> 
                        ICT Equipment Inspection
                    </a>
                    <!--a href="software_development">
                        <i class="fas fa-code"></i> 
                        Software Development
                    </a-->
                </div>
                </div>

                <a href="status" class="status-link">
                    <i class="fas fa-info-circle"></i> Status
                </a>
                <a href="#" onclick="confirmLogout()" title="Logout">
                    <i class="fas fa-power-off"></i> Logout
                </a>
                <script src="asset/js/logout.js"></script>
    
            </div>
</div>
<form action="inspection_form" method="POST">
        <!-- Form Container -->
        <div class="form-container">
            <h1>ICT Equipment Inspection Form</h1>
            <hr>

            <!-- Table-like Form Layout -->
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
                        <td><input type="text" name="item" placeholder="Item/Description" required></td>
                        <td><input type="text" id="prop_no" name="property_no" placeholder="Property Number" ></td>
                        <td><input type="text" id="receipt_no" name="receipt_no" placeholder="Receipt No."></td>
                    </tr>
                </tbody>
            </table>

            <!-- Acquisition Cost and Acquisition Date -->
            <div class="form-row">
            <div class="form-group">
                    <label for="acquisitionCost">Acquisition Cost</label>
                    <div style="position: relative;">
                        <input type="text" id="acquisitionCost" name="acquisition_cost" placeholder="Enter Acquisition Cost" oninput="formatPesoInput(event)">
                        <button type="button" onclick="clearInput()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #888; font-size: 14px; cursor: pointer;">&times;</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="acquisitionDate">Acquisition Date</label>
                    <input type="date" id="acquisitionDate" name="acquisition_date">
                </div>
            </div>

            <!-- Complaints and Nature of Last Repair -->
            <div class="form-row">
                <div class="form-group">
                    <label for="complaints">Complaints</label>
                    <textarea id="complaints" name="complaints" rows="4" placeholder="Enter Complaints" required></textarea>
                </div>
                <div class="form-group">
                    <label for="lastRepair">Nature and Scope of Last Repair, if any</label>
                    <textarea id="lastRepair" name="scope_last_repair" rows="4" placeholder="Enter Nature and Scope of Last Repair"></textarea>
                </div>
            </div>
            <!-- Submit Form Button -->
            <div class="form-actions">
                <button class="apply">Submit Form</button>
            </div>
        </div>
    </div>

    <script src="asset/js/toggle_navbar.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

                const numericInputs = document.querySelectorAll("#prop_no, #receipt_no");

                numericInputs.forEach(input => {
                    input.addEventListener("input", function () {
                        this.value = this.value.replace(/[^0-9-]/g, ""); 
                    });
                });
            });
            function formatPesoInput(event) {
    const inputField = event.target;
    let value = inputField.value.replace(/[^\d.]/g, ''); // Remove non-numeric characters except '.'

    if (value.startsWith('.')) {
        value = '0' + value; // Ensure leading decimal is converted to "0."
    }

    // Limit to two decimal places
    if (value.includes('.')) {
        let parts = value.split('.');
        parts[1] = parts[1].substring(0, 2); // Keep only two decimal places
        value = parts.join('.');
    }

    // Format with commas
    let [wholePart, decimalPart] = value.split('.');
    wholePart = wholePart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    // Ensure the peso sign is always at the beginning
    if (decimalPart !== undefined) {
        inputField.value = '₱' + wholePart + '.' + decimalPart;
    } else {
        inputField.value = '₱' + wholePart;
    }
}

function clearInput() {
    document.getElementById('acquisitionCost').value = ''; 
}

    </script>
</body>
</html>