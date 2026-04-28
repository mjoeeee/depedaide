<?php
include 'all_function.php';
include 'config.php';
include 'query/software_development.php';   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Development Request Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_software_development.css">
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
    <a href="dashboard" class="status-link">
         <i class="fas fa-chart-line"></i></i> Dashboard
        </a>
        <div class="dropdown" onclick="toggleDropdown(this)">
            <a href="#">
                <i class="fas fa-file-alt"></i> <!-- Icon for Request Forms -->
                Request Forms
                <i class="fas fa-chevron-down" style="margin-left: auto;"></i> <!-- Dropdown arrow -->
            </a>
            <div class="dropdown-content">
                <a href="printing_id_card">
                    <i class="fas fa-print"></i> <!-- Icon for Printing -->
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
                <a href="software_development" style="font-weight: bold; color:rgb(238, 108, 21);">
                    <i class="fas fa-code"></i> 
                    Software Development
                </a>
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

<form action="software_development" method="POST" enctype="multipart/form-data">

        <div class="form-container">
            <h1>Software Development Request Form</h1>
            <hr>

            <div class="form-group">
                <div class="row">
                    <div class="input-group">
                        <label for="projectName">Project Name</label>
                        <input type="text" id="projectName" name="proj_name" placeholder="Enter project name" required>
                    </div>
                    <div class="input-group">
                        <label for="briefDescription">Brief Description</label>
                        <textarea id="briefDescription" name="brief_desc" rows="4" placeholder="Enter brief description" required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="input-group">
                        <label for="primaryObjectives">Primary Objectives</label>
                        <textarea id="primaryObjectives" name="prime_obj" rows="4" placeholder="Enter primary objectives" required></textarea>
                    </div>
                    <div class="input-group">
                        <label for="keyFeatures">Key Features/Functionalities</label>
                        <textarea id="keyFeatures" name="features" rows="4" placeholder="Enter key features/functionalities"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="input-group">
                        <label for="designSpecifications">Design Specifications</label>
                        <textarea id="designSpecifications" name="spec" rows="4" placeholder="Enter design specifications" required></textarea>
                    </div>
                    <div class="input-group">
                        <label for="additionalInfo">Additional Information, if any</label>
                        <textarea id="additionalInfo" name="add_info" rows="4" placeholder="Enter additional information"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="input-group">
                        <label for="projectDate">Project Deadline</label>
                        <input type="datetime-local" id="projectDate" name="proj_deadline" 
                                min="<?= date('Y-m-d\TH:i'); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="inspoFiles">Attach Inspo Files</label>
                        <div class="preview-container">
                            <div id="imagePreviewBox">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        </div>
                        <input type="file" id="inspoFiles" name="attachment" onchange="previewImage(event)">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="reset" class="reset">Reset Form</button>
                <button type="submit" class="apply">Submit Form</button>
            </div>
        </div>
    </div>
</form>
<script>
    function previewImage(event) {
        const input = event.target;
        const previewBox = document.getElementById('imagePreviewBox');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewBox.innerHTML = `<img src="${e.target.result}" alt="Screenshot Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
            } else {
            previewBox.innerHTML = `<i class="fa-solid fa-image"></i>`;
        }
    }
</script>

<script src="asset/js/toggle_navbar.js"></script>
</body>
</html>