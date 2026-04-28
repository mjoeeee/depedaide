
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'all_function.php';
include 'config.php';
include 'query/documentation.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_documentation.css">
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
        <!-- Dropdown -->
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
                <a href="documentation" style="font-weight: bold; color:rgb(238, 108, 21);">
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
</div>

    <form action="documentation" method="POST">
        <!-- Form Container -->
        <div class="form-container">
            <h1>Documentation</h1>
            <hr>
        
            <!-- Event Fields -->
            <div class="form-group">
                <label>Event Title</label>
                <div class="row">
                    <input type="text" name="title" placeholder="Event Title" required>
                </div>
            </div>
            <!-- Event Fields -->
            <div class="form-group">
                <label>Location of Event</label>
                <div class="row">
                    <input type="text" name="event_location" placeholder="Location of Event" required>
                </div>
            </div>
            <div class="form-group">
                <label>Event Date and Time</label>
                <div class="row">
                    <input type="date" name="event_date" id="event_date" required min="<?= date('Y-m-d'); ?>" >
                    <input type="time" name="start_time" required> <p><strong>To</strong></p>
                    <input type="time" name="end_time" required>
                </div>
            </div>
            <div class="form-group">
                <label>Details</label>
                <div class="row">
                    <textarea name="details" class="form-control" rows="6" style="width: 100%; height: 200px;" placeholder="Enter details here..."></textarea>               
                </div>
            </div>

            <div class="form-actions">
                <button class="apply">Apply Request</button>
            </div>
        </div>
    </form>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startTimeInput = document.querySelector('input[name="start_time"]');
        const endTimeInput = document.querySelector('input[name="end_time"]');

        // Update the end time based on the start time
        startTimeInput.addEventListener("input", function () {
            const startTime = startTimeInput.value; // Get the start time directly as string
            const startHour = parseInt(startTime.split(":")[0]); // Extract the hour part
            const startMinute = parseInt(startTime.split(":")[1]); // Extract the minute part
            
            // Create a Date object for the start time, set to 1 hour later
            const endTime = new Date();
            endTime.setHours(startHour, startMinute + 60); // Add 1 hour to the start time
            
            // Format end time to HH:mm format
            const formattedEndTime = endTime.toTimeString().substr(0, 5);
            endTimeInput.value = formattedEndTime; // Set the calculated end time
            
            // Set the minimum end time to be 1 hour after start time
            endTimeInput.setAttribute("min", formattedEndTime);
        });

        // Ensure the end time is at least 1 hour after the start time
        endTimeInput.addEventListener("input", function () {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            // Parse both start and end times to compare them
            const startParts = startTime.split(":");
            const endParts = endTime.split(":");

            const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
            const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);

            // If the end time is less than 1 hour after the start time, show an error
            if (endMinutes <= startMinutes + 60) {
                endTimeInput.setCustomValidity("End time must be at least 1 hour after start time.");
            } else {
                endTimeInput.setCustomValidity(""); // Reset validity if the input is correct
            }
        });
    });
</script>



<script src="asset/js/toggle_navbar.js"></script>
</body>
</html>