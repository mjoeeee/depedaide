
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'all_function.php';
include 'config.php';
include 'query/deped_email.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request for DepEd Email</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_deped_email.css">
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

        
<div class="form-container">
    <form action="deped_email" method="POST">
        <h1>REQUEST FOR DEPED EMAIL</h1>
        <hr>
        <div class="form-group">
            <label for="officeId">Office/School ID</label>
            <input type="text" id="officeId" name="officeId" placeholder="Enter Office/School ID" required>
        </div>

        <div class="form-group" style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label><strong>Firstname</strong></label>
                <input type="text" value="<?php echo $_SESSION['firstname']; ?>" readonly style="background-color: #f3f3f3; border: 1px solid #ccc; padding: 5px;" required>
            </div>
            <div style="flex: 1;">
                <label><strong>Lastname</strong></label>
                <input type="text" value="<?php echo $_SESSION['lastname']; ?>" readonly style="background-color: #f3f3f3; border: 1px solid #ccc; padding: 5px;" required>
            </div>
            <div style="flex: 0.2;">
                <label><strong>Suffix</strong></label>
                <input type="text" id="suffixInput" name="suffix" 
                    value="<?php echo !empty($_SESSION['extname']) ? $_SESSION['extname'] : 'N/A'; ?>" 
                    readonly style="background-color: #f3f3f3; border: 1px solid #ccc; padding: 5px;">

            </div>

        </div>

        <script>
        function toggleSuffixInput(select) {
            var otherInput = document.getElementById("otherSuffix");
            otherInput.style.display = (select.value === "Other") ? "block" : "none";
            if (select.value !== "Other") {
                otherInput.value = ""; 
            }
        }
        window.onload = function() {
            if (document.getElementById("suffixSelect").value === "Other") {
                document.getElementById("otherSuffix").style.display = "block";
            }
        };
        
        document.addEventListener("DOMContentLoaded", function () {

                const numericInputs = document.querySelectorAll("#officeId");

                numericInputs.forEach(input => {
                    input.addEventListener("input", function () {
                        this.value = this.value.replace(/[^0-9-]/g, ""); 
                    });
                });
            });
        </script>   

        <div class="form-group">
            <div class="row" style="display: flex; gap: 20px; align-items: center;">
                <div style="flex: 1;">
                    <label for="position"><strong>Position</strong></label>
                    <input type="text" id="position" name="position" 
                        value="<?php echo isset($_SESSION['job_title']) ? htmlspecialchars($_SESSION['job_title']) : 'N/A'; ?>" 
                        readonly style="background-color: #f3f3f3; border: 1px solid #ccc; padding: 5px; width: 100%;">
                </div>
                <div style="flex: 1;">
                    <label for="email_format"><strong>DepEd Email</strong></label>
                    <input type="email" id="email_format" name="email_format" placeholder="DepEd Email" 
                        value="<?php 
                            $suffix = isset($_SESSION['extname']) ? preg_replace('/[^a-zA-Z ]/', '', $_SESSION['extname']) : ''; 
                            echo strtolower($_SESSION['firstname'] . (!empty($suffix) ? '' . $suffix : '') . '.' . $_SESSION['lastname'] . '@deped.gov.ph'); 
                        ?>" required style="background-color: #f3f3f3; border: 1px solid #ccc; padding: 5px; width: 100%;" readonly>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="apply">Apply Request</button>
        </div>
    </form>
</div>
<script src="asset/js/toggle_navbar.js"></script>
</body>
</html>