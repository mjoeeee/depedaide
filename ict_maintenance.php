
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'all_function.php';
include 'config.php';
include 'query/ict_maintenance.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="asset/main.css">
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/user_ict_maintenance.css">
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


<script>

</script>
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
        <div class="content">
            <div class="form-container">
                <h2 style="text-align:center; margin:auto;">ICT Maintenance Request Form</h2>
                <hr style="height: 1px; background-color: gray; border: none;"> 

                <form action="ict_maintenance" method="POST">

                    <table>
                        <tr>
                            <th colspan="2">I</th>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td><input type="date" name="date" required></td>
                        </tr>
                        <tr>
                            <td>Time:</td>
                            <td><input type="time" name="time" required></td>
                        </tr>
                        <tr>
                            <td>Requested by:</td>
                            <td>
                                Name: <input type="text" name="name" value="<?php echo $_SESSION['fullname']; ?>" required><br>
                                Designation: <input type="text" name="designation" value="<?php echo $_SESSION['job_title']; ?>" required><br>
                                Division Office: <br>
                                <select name="divisionOffice" required>
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

                                foreach ($offices as $office) {
                                    echo "<option value='$office'>$office</option>";
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
                <td width="71.5%"><input type="text" name="propertyDescription"></td>
            </tr>
            <tr>
                <td>Brand:</td>
                <td><input type="text" name="brand"></td>
            </tr>
            <tr>
                <td>Property No.:</td>
                <td><input type="text" name="propertyNumber"></td>
            </tr>
            <tr>
                <td>Serial/Engine No.:</td>
                <td><input type="text" name="serialNumber"></td>
            </tr>
            <tr>
                <td>Date of Last Repair:</td>
                <td><input type="date" name="lastRepairDate"></td>
            </tr>
            <tr>
                <td>Defects/Complaints:</td>
                <td><textarea name="defects" rows="4"></textarea></td>
            </tr>
        </table>

        <button type="submit" class="submit-button" style="display: block; margin-left: auto;">Submit Form</button>

                </form>
            </div>
        </div>
    </div>

    <!-- Script to Toggle Sidebar and Dropdown -->
    <script src="asset/js/toggle_navbar.js"></script>
</html>