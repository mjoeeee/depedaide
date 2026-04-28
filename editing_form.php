
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'all_function.php';
include 'config.php';
include 'query/editing_form.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Visual Editing Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/user_editing_form.css">
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
                <a href="documentation">
                    <i class="fas fa-file-alt"></i> 
                    Documentation
                </a>
                <a href="editing_form" style="font-weight: bold; color:rgb(238, 108, 21);">
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
<form action="editing_form" method="POST">
        <!-- Form Container -->
    <div class="form-container">
            <h1>Audio Visual Editing Form</h1>
            <hr>

            <!-- Project Title/Name -->
            <div class="form-group">
                <label for="projectTitle">Project Title/Name</label>
                <input type="text" id="projectTitle" placeholder="Enter Project Title/Name" name="title" required>
            </div>

            <!-- Project Description -->
            <div class="form-group">
                <label for="projectDescription">Project Description</label>
                <textarea id="projectDescription" name="proj_desc" rows="4" placeholder="Enter Project Description" required></textarea>
            </div>

            <!-- Type of Project and Music Preferences -->
            <div class="form-row">
            <div class="form-group"> 
                <label for="projectType">Type of Project</label>
                <select id="projectType" name="project_type" class="form-control" required>
                    <option value="">Select Project</option>
                    <option value="Corporate Video">Corporate Video</option>
                    <option value="Event Video">Event Video</option>
                    <option value="Promotional Video">Promotional Video</option>
                    <option value="Tutorial/Training Video">Tutorial/Training Video</option>
                    <option value="Documentary">Documentary</option>
                    <option value="Tarpaulin">Tarpaulin</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="otherProjectDiv" style="display: none;">
                <label for="otherProject">Specify Other Project</label>
                <input type="text" id="otherProject" name="project_type" class="form-control" placeholder="Enter project type">
            </div>

            <script>
                document.getElementById("projectType").addEventListener("change", function() {
                    var otherProjectDiv = document.getElementById("otherProjectDiv");
                    var otherProjectInput = document.getElementById("otherProject");
                    var musicPreferencesDiv = document.getElementById("musicPreferencesDiv");

                    if (this.value === "Other") {
                        otherProjectDiv.style.display = "block";
                        this.removeAttribute("name"); // Remove name from select
                        otherProjectInput.setAttribute("name", "project_type"); // Assign name to input
                    } else {
                        otherProjectDiv.style.display = "none";
                        otherProjectInput.removeAttribute("name"); // Remove name from input
                        this.setAttribute("name", "project_type"); // Assign name back to select
                    }

                    // Hide music preferences if "Tarpaulin" is selected
                    if (this.value === "Tarpaulin") {
                        musicPreferencesDiv.style.display = "none";
                        deliverables.style.display = "none";
                        style_tone.style.display = "none";
                        musicPreferencesDiv.querySelectorAll("input, select, textarea").forEach(el => el.removeAttribute("required"));
                        deliverables.querySelectorAll("input, select, textarea").forEach(el => el.removeAttribute("required"));
                        style_tone.querySelectorAll("input, select, textarea").forEach(el => el.removeAttribute("required"));
                    } else {
                        musicPreferencesDiv.style.display = "block";
                        deliverables.style.display = "block";
                        style_tone.style.display = "block";
                        musicPreferencesDiv.querySelectorAll("input, select, textarea").forEach(el => el.setAttribute("required", true));
                        deliverables.querySelectorAll("input, select, textarea").forEach(el => el.setAttribute("required", true));
                        style_tone.querySelectorAll("input, select, textarea").forEach(el => el.setAttribute("required", true));
                    }


                });


            </script>

                <div class="form-group" id="musicPreferencesDiv">
                    <label for="musicPreferences">Music Preferences</label>
                    <select id="musicPreferences" name="music_preference" >
                        <option  value="">Select Music Preference</option>
                        <option value="Background Music">Background Music</option>
                        <option value="No Music">No Music</option>
                        <option value="Music Provided by Client">Music Provided by Client</option>
                    </select>
                </div>
            </div>

<!-- Expected Deliverables and Project Style & Tone -->
<div class="form-row">
<div class="form-group">
                <label for="deliverables">Expected Deliverables</label>
                <select id="deliverables" name="deliverables" class="form-control">
                    <option value="">Select Deliverables</option>
                    <option value="Edited Video">Edited Video</option>
                    <option value="Audio-Only">Audio-Only</option>
                    <option value="Image-Only">Image-Only</option>
                    <option value="Raw Footage/Audio">Raw Footage/Audio</option>
                    <option value="Clips">Clips</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="otherDeliverableDiv" style="display: none;">
                <label for="otherDeliverable">Specify Other Deliverable</label>
                <input type="text" id="otherDeliverable" name="deliverables" class="form-control" placeholder="Enter deliverable">
            </div>

            <script>
                document.getElementById("deliverables").addEventListener("change", function() {
                    var otherDeliverableDiv = document.getElementById("otherDeliverableDiv");
                    var otherDeliverableInput = document.getElementById("otherDeliverable");

                    if (this.value === "Other") {
                        otherDeliverableDiv.style.display = "block";
                        this.removeAttribute("name"); // Remove name from select
                        otherDeliverableInput.setAttribute("name", "deliverables"); // Assign name to input
                    } else {
                        otherDeliverableDiv.style.display = "none";
                        otherDeliverableInput.removeAttribute("name"); // Remove name from input
                        this.setAttribute("name", "deliverables"); // Assign name back to select
                    }
                });
            </script>

            
<script>
    document.getElementById("projectType").addEventListener("change", function() {
        var otherProjectDiv = document.getElementById("otherProjectDiv");
        var otherProjectInput = document.getElementById("otherProject");
        var musicPreferencesDiv = document.getElementById("musicPreferencesDiv");
        var deliverables = document.getElementById("deliverables");
        var styleTone = document.getElementById("style_tone");

        if (this.value === "Other") {
            otherProjectDiv.style.display = "block";
            this.removeAttribute("name"); 
            otherProjectInput.setAttribute("name", "project_type"); 
        } else {
            otherProjectDiv.style.display = "none";
            otherProjectInput.removeAttribute("name"); 
            this.setAttribute("name", "project_type");
        }

        // Hide fields when "Tarpaulin" is selected
        if (this.value === "Tarpaulin") {
            musicPreferencesDiv.style.display = "none";
            document.querySelector("label[for='deliverables']").style.display = "none";
            deliverables.style.display = "none";
            styleTone.style.display = "none";
        } else {
            document.querySelector("label[for='deliverables']").style.display = "block";
            musicPreferencesDiv.style.display = "block";
            deliverables.style.display = "block";
            styleTone.style.display = "block";
        }
    });

    document.getElementById("projectStyle").addEventListener("change", function() {
        var otherProjectStyleDiv = document.getElementById("otherProjectStyleDiv");
        var otherProjectStyleInput = document.getElementById("otherProjectStyle");

        if (this.value === "Other") {
            otherProjectStyleDiv.style.display = "block";
            this.removeAttribute("name");
            otherProjectStyleInput.setAttribute("name", "style_tone");
            // Add a border for better visibility
            otherProjectStyleInput.style.border = "2px solid #007bff";
            otherProjectStyleInput.style.padding = "5px";
        } else {
            otherProjectStyleDiv.style.display = "none";
            otherProjectStyleInput.removeAttribute("name");
            this.setAttribute("name", "style_tone");
        }
    });
</script>


            <div class="form-group" id="style_tone">
                <label for="projectStyle">Project Style & Tone</label>
                <select id="projectStyle" name="style_tone" class="form-control"> 
                    <option value="">Select Style</option>
                    <option value="Cinematic">Cinematic</option>
                    <option value="Documentary-Style">Documentary-Style</option>
                    <option value="Corporate/Professional">Corporate/Professional</option>
                    <option value="Casual/Informal">Casual/Informal</option>
                    <option value="High-Energy">High-Energy</option>
                    <option value="Artistic/Experimental">Artistic/Experimental</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="otherProjectStyleDiv" style="display: none;">
                <label for="otherProjectStyle">Specify Other Style & Tone</label>
                <input type="text" id="otherProjectStyle" name="style_tone" class="form-control" placeholder="Enter style">
            </div>

            <script>
                document.getElementById("projectStyle").addEventListener("change", function() {
                    var otherProjectStyleDiv = document.getElementById("otherProjectStyleDiv");
                    var otherProjectStyleInput = document.getElementById("otherProjectStyle");

                    if (this.value === "Other") {
                        otherProjectStyleDiv.style.display = "block";
                        this.removeAttribute("name"); // Remove name from select
                        otherProjectStyleInput.setAttribute("name", "style_tone"); // Assign name to input
                    } else {
                        otherProjectStyleDiv.style.display = "none";
                        otherProjectStyleInput.removeAttribute("name"); // Remove name from input
                        this.setAttribute("name", "style_tone"); // Assign name back to select
                    }
                });
            </script>

            </div>

            <!-- Preferred Delivery Method and Project Deadline -->
            <div class="form-row">

            <div class="form-group">
                <label for="deliveryMethod">Preferred Delivery Method</label>
                <select id="deliveryMethod" name="delivery_method" required class="form-control">
                    <option value="">Select Delivery</option>
                    <option value="Google Drive">Google Drive</option>
                    <option value="Dropbox">Dropbox</option>
                    <option value="WeTransfer">WeTransfer</option>
                    <option value="FTP Upload">FTP Upload</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="otherDeliveryMethodDiv" style="display: none;">
                <label for="otherDeliveryMethod">Specify Other Delivery Method</label>
                <input type="text" id="otherDeliveryMethod" name="delivery_method" class="form-control" placeholder="Enter method">
            </div>

            <script>
                document.getElementById("deliveryMethod").addEventListener("change", function() {
                    var otherDeliveryMethodDiv = document.getElementById("otherDeliveryMethodDiv");
                    var otherDeliveryMethodInput = document.getElementById("otherDeliveryMethod");

                    if (this.value === "Other") {
                        otherDeliveryMethodDiv.style.display = "block";
                        this.removeAttribute("name"); // Remove name from select
                        otherDeliveryMethodInput.setAttribute("name", "delivery_method"); // Assign name to input
                    } else {
                        otherDeliveryMethodDiv.style.display = "none";
                        otherDeliveryMethodInput.removeAttribute("name"); // Remove name from input
                        this.setAttribute("name", "delivery_method"); // Assign name back to select
                    }
                });
            </script>


                <div class="form-group">
                    <label for="projectDeadline">Project Deadline</label>
                    <input type="datetime-local" id="projectDeadline" name="project_deadline" 
                        min="<?= date('Y-m-d\TH:i'); ?>" required>

                </div>
            </div>

            <!-- Submit Form Button -->
            <div class="form-actions">
                <button class="apply">Submit Form</button>
            </div>
        </div>
    </div>
</form>
<script src="asset/js/toggle_navbar.js"></script>
</body>
</html>