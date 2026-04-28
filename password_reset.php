<?php
include 'all_function.php';
include 'config.php';
include 'query/password_reset.php';
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
    <link rel="stylesheet" href="asset/css/user_password_reset.css">
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

 <!-- Form Container -->
<form action="password_reset" method="POST" enctype="multipart/form-data">
    <div class="form-container">
        <h1>Email Concern</h1>
        <hr>

        <div class="form-group">
            <label for="personalEmail">DepEd Email</label>
            <input type="email" id="personalEmail" placeholder="Enter your personal email" value="<?php echo $_SESSION['email']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea id="reason" rows="4" name="reason" placeholder="Enter your reason" required></textarea>
        </div>

        <div class="form-group file-preview-container">
            <div>
                <label for="attachment">Screenshot</label>
                <div class="preview-container">
                <div id="imagePreviewBox">
                    <i class="fa-solid fa-image"></i>
                </div>
            </div>
                <input type="file" name="attachment" style="width:30%;" id="attachment" accept="image/*" onchange="previewImage(event)">
            </div>
        </div>

        <div class="form-actions">
            <button class="apply">Apply Request</button>
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
            previewBox.innerHTML = `<i class="fa-solid fa-image"></i>`; // Reset to default icon
        }
    }
</script>





</div>

<script src="asset/js/toggle_navbar.js"></script>
</body>
</html>