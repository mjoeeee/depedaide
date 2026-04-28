
<?php       
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/pending_navbar.php';
include 'query/dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../asset/css/calendar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../asset/css/admin_dashboard.css">
    <link rel="stylesheet" href="../asset/css/profile_link.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

    </style>
</head>
<body>
<nav class="navbar-custom">
    <a class="navbar-brand" href="dashboard">
        <img src="../image/logo (1).png" alt="Logo">
    </a>
    <div class="burger-menu" style="margin-right:30px;" onclick="toggleSidebar()">
        <div></div>
        <div></div>
        <div></div>
    </div>

</nav>


    <div class="container">
    <div class="sidebar" id="sidebar">
            <div class="profile-container">
                <h3 class="profile-link">
                <i class="fas fa-user-shield me-1"></i>
                    <?php echo $_SESSION['fullname']; ?>
                </h3>
            </div>
        <div>
        <a href="dashboard" style="font-weight: bold; color:rgb(238, 108, 21);">
            <i class="fas fa-dashboard"></i> Dashboard
        </a>
        <a href="deped_email">
            <i class="fas fa-envelope"></i> DepEd Email <span class="badge"><?= isset($pending_counts['deped_email_request']) ? $pending_counts['deped_email_request'] : 0 ?></span>
        </a>
        <a href="reset_email">
            <i class="fas fa-key"></i> Email Concern <span class="badge"><?= isset($pending_counts['password_reset']) ? $pending_counts['password_reset'] : 0 ?></span>
        </a>
        <!--a href="id_card">
            <i class="fas fa-id-card"></i> ID Card Requests <span class="badge"><?= isset($pending_counts['id_card_printing']) ? $pending_counts['id_card_printing'] : 0 ?></span>
        </a-->
        <a href="ict_maintenance">
            <i class="fas fa-tools"></i> ICT Maintenance <span class="badge"><?= isset($pending_counts['ict_maintenance']) ? $pending_counts['ict_maintenance'] : 0 ?></span>
        </a>
        <!--a href="document">
            <i class="fas fa-file-alt"></i> Documentation <span class="badge"><?= isset($pending_counts['documentation']) ? $pending_counts['documentation'] : 0 ?></span>
        </a>
        <a href="audio">
            <i class="fas fa-video"></i> Audio Visual Editing <span class="badge"><?= isset($pending_counts['audio_visual_editing']) ? $pending_counts['audio_visual_editing'] : 0 ?></span>
        </a-->
        <a href="ict_inspection">
            <i class="fas fa-search"></i> ICT Inspection <span class="badge"><?= isset($pending_counts['ict_equipment_inspection']) ? $pending_counts['ict_equipment_inspection'] : 0 ?></span>
        </a>
        <!--a href="software_request">
            <i class="fas fa-code"></i> Software Development <span class="badge"><?= isset($pending_counts['software_development']) ? $pending_counts['software_development'] : 0 ?></span>
        </a-->
        <div class="logout-button">
            <a href="#" onclick="confirmLogout()" title="Logout">
                <i class="fas fa-power-off"></i> Logout
            </a>
        </div>

        <script src="../asset/js/logout_admin.js"></script>
    </div>
    <!-- Sidebar Logo -->
    <div class="sidebar-logo">
        <img src="../image/Primary.png" alt="Sidebar Logo"> <!-- Replace with your logo path -->
    </div>
</div>
 

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Header Card -->
            <div class="dashboard-header-card">
                <!--h1>Welcome Admin! <?php echo $_SESSION['fullname']; ?></h1-->
                <div class="time-date" id="timeDate"></div>
                <div style="display: flex; justify-content: center; align-items: center; gap: 15px; margin-top: 5px; font-size: 12px; color: #555;">
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-hourglass-half" style="color: #f39c12; font-size: 12px;"></i> Pending
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-spinner" style="color: #3498db; font-size: 12px; animation: spin 1s linear infinite;"></i> In-Progress
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-check-circle" style="color: #2ecc71; font-size: 12px;"></i> Completed
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-ban" style="color:rgb(226, 0, 0); font-size: 12px;"></i> Rejected
                    </span>
                </div>
            </div>

            <!-- Cards -->
  <div class="card-container">
    <!-- Card 2: DepEd Email -->
    <a href="deped_email" style="text-decoration: none;">
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-envelope"></i>
                <p><?php echo $em_count; ?></p>
            </div>
            <h3>Email Creation</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['deped_email_request']['Pending']) ? $request_counts['deped_email_request']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['deped_email_request']['In Progress']) ? $request_counts['deped_email_request']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['deped_email_request']['Completed']) ? $request_counts['deped_email_request']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i> 
                    <b><?= isset($request_counts['deped_email_request']['Rejected']) ? $request_counts['deped_email_request']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a>

    <a href="reset_email" style="text-decoration: none;">
        <!-- Card 3: Reset Password -->
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-key"></i> 
                <p><?php echo $passresetCount; ?></p> 
            </div>
            <h3>Email Concern</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['password_reset']['Pending']) ? $request_counts['password_reset']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['password_reset']['In Progress']) ? $request_counts['password_reset']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['password_reset']['Completed']) ? $request_counts['password_reset']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i> 
                    <b><?= isset($request_counts['password_reset']['Rejected']) ? $request_counts['password_reset']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a>

    <!--a href="id_card" style="text-decoration: none;">   
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-id-card"></i> 
                <p><?= array_sum($request_counts['id_card_printing']); ?></p>
            </div>
            <h3>Printing ID Card</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['id_card_printing']['Pending']) ? $request_counts['id_card_printing']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['id_card_printing']['In Progress']) ? $request_counts['id_card_printing']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['id_card_printing']['Completed']) ? $request_counts['id_card_printing']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i> 
                    <b><?= isset($request_counts['id_card_printing']['Rejected']) ? $request_counts['id_card_printing']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a-->
<!-- Card 4: ICT Maintenance -->
    <a href="ict_maintenance" style="text-decoration: none;">
        
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-tools"></i> 
                <p><?php echo $ictmrf_count; ?></p> 
            </div>
            <h3>ICT Maintenance</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['ict_maintenance']['Pending']) ? $request_counts['ict_maintenance']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['ict_maintenance']['In Progress']) ? $request_counts['ict_maintenance']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['ict_maintenance']['Completed']) ? $request_counts['ict_maintenance']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i> 
                    <b><?= isset($request_counts['ict_maintenance']['Rejected']) ? $request_counts['ict_maintenance']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a>
 <!-- Card 5: Documentation -->
    <!--a href="document" style="text-decoration: none;">
       
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-file-alt"></i> 
                <p><?php echo $documentCount; ?></p> 
            </div>
            <h3>Documentation</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['documentation']['Pending']) ? $request_counts['documentation']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['documentation']['In Progress']) ? $request_counts['documentation']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['documentation']['Completed']) ? $request_counts['documentation']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i>
                    <b><?= isset($request_counts['documentation']['Rejected']) ? $request_counts['documentation']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a-->
 <!-- Card 6: Audio Visual Editing -->
    <!--a href="audio" style="text-decoration: none;">
       
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-video"></i> 
                <p><?php echo $audiovisualCount; ?></p> 
            </div>
            <h3>Audio Visual Editing</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['audio_visual_editing']['Pending']) ? $request_counts['audio_visual_editing']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['audio_visual_editing']['In Progress']) ? $request_counts['audio_visual_editing']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['audio_visual_editing']['Completed']) ? $request_counts['audio_visual_editing']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i>
                    <b><?= isset($request_counts['audio_visual_editing']['Rejected']) ? $request_counts['audio_visual_editing']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a-->
      <!-- Card 7: ICT Equipment Inspection -->
    <a href="ict_inspection" style="text-decoration: none;">
  
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-desktop"></i> 
                <p><?php echo $inspectionCount; ?></p>
            </div>  
            <h3>ICT Inspection</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['ict_equipment_inspection']['Pending']) ? $request_counts['ict_equipment_inspection']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['ict_equipment_inspection']['In Progress']) ? $request_counts['ict_equipment_inspection']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['ict_equipment_inspection']['Completed']) ? $request_counts['ict_equipment_inspection']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i>
                    <b><?= isset($request_counts['ict_equipment_inspection']['Rejected']) ? $request_counts['ict_equipment_inspection']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a>
   <!-- Card 8: Software Development -->
    <!--a href="software_request" style="text-decoration: none;">
     
        <div class="card">
            <div class="centered-container">
                <i class="fas fa-code"></i> 
                <p><?php echo $softdevCount; ?></p> 
            </div>
            <h3>Software Devt</h3>
            <div class="status-container">
                <span class="status-item">
                    <i class="fas fa-hourglass-half pending-icon"></i> 
                    <b><?= isset($request_counts['software_development']['Pending']) ? $request_counts['software_development']['Pending'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-spinner in-progress-icon"></i>  
                    <b><?= isset($request_counts['software_development']['In Progress']) ? $request_counts['software_development']['In Progress'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-check-circle completed-icon"></i> 
                    <b><?= isset($request_counts['software_development']['Completed']) ? $request_counts['software_development']['Completed'] : 0; ?></b>
                </span>
                <span class="status-item">
                    <i class="fas fa-ban rejected-icon"></i>
                    <b><?= isset($request_counts['software_development']['Rejected']) ? $request_counts['software_development']['Rejected'] : 0; ?></b>
                </span>
            </div>
        </div>
    </a-->
</div>

            <!-- Chart -->
            <div class="chart-container">
                <canvas id="requestChart"></canvas>
            </div>
        </div>
    </div>
    <div class="form-container">
                    <div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 15px;">
                        <button id="toggleCalendar" class="toggle-btn" 
                            style="position: absolute; left: 0; background-color: #007bff; color: white; border: none; padding: 4px 8px; font-size: 13px; border-radius: px; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-compress" style="margin-right: 3px;"></i> Minimize
                        </button>
                        <h1 style="margin: 0; text-align: center;">Request Status Calendar</h1>
                    </div>
                    <div class="calendar_container" style="margin-bottom: 10%;"> 
                            <hr>
                            <p style="text-align: center; font-size: 10px; color: #000;">Click on the event to see details.</p>
                        <div id="calendar">
                        </div>
                    </div>    
    </div>
<script>
$(document).ready(function () {
    fetch("query/fetch_calendar.php?request_id=all")
    .then(response => response.text()) 
        .then(text => new TextDecoder("utf-8").decode(new Uint8Array([...text].map(c => c.charCodeAt(0))))) 
        .then(json => JSON.parse(json)) 
        .then(data => {
            let events = data.map(event => {
                let backgroundColor;
                switch (event.stat.toLowerCase()) {
                    case "pending":
                        backgroundColor = "#f9aa0b";
                        break;
                    case "in progress":
                        backgroundColor = "#0a72cf";
                        break;
                    case "completed":
                        backgroundColor = "#358308";
                        break;
                    case "rejected":
                        backgroundColor = "#ec160b";
                        break;
                    default:
                        backgroundColor = "gray";
                }


                return {
                    title: event.fullname, // Use formatted title
                    start: event.created_at,
                    request_id: event.request_id,
                    stat: event.stat,
                    description: event.request_type_table,
                    extendedProps: {
                        stat: event.stat,
                        remarks: event.remarks,
                        email: event.fullname,
                        deadline: event.created_at,
                        request_id: event.request_id,
                        request_type: event.request_type_table // Keep original request type
                    },
                    backgroundColor: backgroundColor,
                    borderColor: backgroundColor,
                    textColor: "white"
                };
            });

            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: events,

                eventClick: function (info) {
                    let stat = info.event.extendedProps.stat || "N/A";
                    let formattedDeadline = "No Deadline";

                    // Define status colors
                    let statusColors = {
                        "Pending": "#f9aa0b",
                        "In Progress": "#0a72cf",
                        "Completed": "#358308",
                        "Rejected": "#ec160b"
                    };
                    let statusColor = statusColors[stat] || "#95a5a6";

                    // Define request type mapping
                    const requestTypeMap = {
                        "ict_maintenance": "ICT Maintenance",
                        "software_development": "Software Development",
                        "ict_equipment_inspection": "ICT Equipment Inspection",
                        "documentation": "Documentation",
                        "audio_visual_editing": "Audio Visual Editing",
                        "deped_email_request": "DepEd Email Request",
                        "password_reset": "Email Concern",
                        "id_card_printing": "ID Card Printing"
                    };

                    let requestTypeKey = info.event.extendedProps.request_type
                        ? info.event.extendedProps.request_type.toLowerCase()
                        : "";
                    let mappedRequestType = requestTypeMap[requestTypeKey] || "Unknown Request Type";

                    if (info.event.extendedProps.deadline) {
                        let deadlineDate = new Date(info.event.extendedProps.deadline);
                        let options = {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                            hour: "2-digit",
                            minute: "2-digit",
                            hour12: true
                        };
                        formattedDeadline = deadlineDate.toLocaleString("en-US", options);
                    }

                    Swal.fire({
                        title: `<i class="fas fa-calendar-alt"></i> ${info.event.title}`,
                        html: `
                            <div style="padding: 15px; border-radius: 10px; background: #f8f9fa;">
                                <p><i class="fas fa-exclamation-circle"></i> <b>Status:</b> <span style="color: ${statusColor}; font-weight: bold;">${stat}</span></p>
                                <p><i class="fas fa-user"></i> <b>Remarks:</b> ${info.event.extendedProps.remarks ? info.event.extendedProps.remarks : "N/A"}</p>
                                <p><i class="fas fa-align-left"></i> <b>Request Type:</b> ${mappedRequestType}</p>
                                <p><i class="fas fa-calendar-day"></i> <b>Date Requested:</b> ${formattedDeadline}</p>
                            </div>
                        `,
                        icon: "info",
                        showCloseButton: true,
                        confirmButtonText: '<i class="fas fa-eye"></i> View'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let requestId = info.event.extendedProps.request_id;
                            let redirectUrl = "";

                            // Define redirection based on request type
                            switch (requestTypeKey) {
                                case "ict_maintenance":
                                    redirectUrl = `ict_maintenance?request_id=${requestId}`;
                                    break;
                                case "software_development":
                                    redirectUrl = `software_request?request_id=${requestId}`;
                                    break;
                                case "ict_equipment_inspection":
                                    redirectUrl = `ict_inspection?request_id=${requestId}`;
                                    break;
                                case "documentation":
                                    redirectUrl = `document?request_id=${requestId}`;
                                    break;
                                case "audio_visual_editing":
                                    redirectUrl = `audio?request_id=${requestId}`;
                                    break;
                                case "deped_email_request":
                                    redirectUrl = `deped_email?request_id=${requestId}`;
                                    break;
                                case "password_reset":
                                    redirectUrl = `reset_email?request_id=${requestId}`;
                                    break;
                                case "id_card_printing":
                                    redirectUrl = `id_card?request_id=${requestId}`;
                                    break;
                                default:
                                    redirectUrl = `dashboard`; // Fallback in case of an unknown type
                            }

                            window.location.href = redirectUrl;
                        }
                    });
                }
            });

            calendar.render();

            let isHidden = false;
            $("#toggleCalendar").click(function () {
                if (isHidden) {
                    $(".calendar_container").show();
                    $(this).html('<i class="fas fa-compress"></i> Minimize');
                } else {
                    $(".calendar_container").hide();
                    $(this).html('<i class="fas fa-expand"></i> Enlarge');
                }
                isHidden = !isHidden;
            });
        })
        .catch(error => console.error("Error fetching events:", error));
});

</script>
    <script>

        function updateTimeDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const formattedDateTime = now.toLocaleDateString('en-US', options);
            document.getElementById('timeDate').textContent = formattedDateTime;
        }

        setInterval(updateTimeDate, 1000);
        updateTimeDate(); 
    </script>

<?php
try {

    $sql = "SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS request_count
            FROM tbl_request_depaide
            GROUP BY MONTH(created_at)
            ORDER BY MONTH(created_at)";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $months = [];
    $counts = [];

    foreach ($result as $row) {
        $months[] = $row['month']; 
        $counts[] = $row['request_count'];
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<script>

    const labels = <?php echo json_encode($months); ?>; 
    const dataValues = <?php echo json_encode($counts); ?>; 

    const ctx = document.getElementById('requestChart').getContext('2d');
    const requestChart = new Chart(ctx, {
        type: 'line', 
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Requests',
                data: dataValues,
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: '#007bff',
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: '#007bff',
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0',
                    }
                },
                x: {
                    grid: {
                        color: '#f0f0f0',
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            }
        }
    });

    function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>