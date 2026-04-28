    <?php
        include 'all_function.php';
        include 'config.php';
        $userId = $_SESSION['userId'];
        include 'query/dashboard.php';
    ?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Request for DepEd Email</title>
        <!-- Add Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" type="text/css" href="asset/css/calendar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="asset/css/user_dashboard.css">
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar-custom">
                    <a class="navbar-brand" href="dashboard">
                    <img src="image/logo (1).png" alt="Logo"><!-- Replace with your logo path -->
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


            <div class="form-container">
            <h1 class="text-center mb-4">Dashboard</h1>
            
            <div class="card-deck">
            <!-- Include Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">




<div class="card-deck">
<a href="ict_maintenance" style="text-decoration: none; color: inherit;">
<div class="card">
    <div class="card-body text-center">
        <i class="fas fa-tools icon" style="font-size: 40px; color: #007bff;"></i>
        <h5 class="card-title">ICT Maintenance</h5>
            <br>
        <a href="ict_maintenance" class="btn btn-xs">Request</a>
        <a href="status?type=ICT Maintenance" class="custom-btn">
            <i class="fas fa-list-check"></i> Total: <?= $ictmrf_count; ?>
        </a>
    </div>
</div>
</a>

  <!-- Software Development -->
<!--a href="software_development" style="text-decoration: none; color: inherit;">
  
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-code icon"></i>
            <h5 class="card-title">Software Development</h5>
            <p class="card-text">
            <br>
            </p>
            <a href="software_development" class="btn btn-xs">Request</a>
            <a href="status?type=Software Development" class="custom-btn">
                <i class="fas fa-list-check"></i> Total: <?= $softdevCount; ?>
            </a>
        </div>
    </div>
</a-->
  <!-- ICT Equipment Inspection -->
<a href="inspection_form" style="text-decoration: none; color: inherit;">
  
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-clipboard-check icon"></i>
            <h5 class="card-title">ICT Equipment Inspection</h5>
            <p class="card-text">
            <br>
            </p>
            <a href="inspection_form" class="btn btn-xs">Request</a>
            <a href="status?type=ICT Equipment Inspection" class="custom-btn">
                <i class="fas fa-list-check"></i> Total: <?= $inspectionCount; ?>
            </a>
        </div>
    </div>
</a>
   <!-- Documentation -->
<!--a href="documentation" style="text-decoration: none; color: inherit;">
 
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-file-alt icon"></i>
            <h5 class="card-title">Documentation</h5>
            <p class="card-text">
            <br>
            </p>
            <a href="documentation" class="btn btn-xs">Request</a>
            <a href="status?type=Documentation" class="custom-btn">
                <i class="fas fa-list-check"></i> Total: <?= $documentCount; ?>
            </a>
        </div>
    </div>
</a-->
<!-- Audio Visual Editing -->
<!--a href="editing_form" style="text-decoration: none; color: inherit;">
    
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-video icon"></i>
            <h5 class="card-title">Audio Visual Editing</h5>
            <p class="card-text">
            <br>
            </p>
            <a href="editing_form" class="btn btn-xs">Request</a>
            <a href="status?type=Audio Visual Editing" class="custom-btn">
                <i class="fas fa-list-check"></i> Total: <?= $audiovisualCount; ?>
            </a>
        </div>
    </div>
</a-->

<a href="password_reset" style="text-decoration: none; color: inherit;">
    <!-- Password Reset -->
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-key icon"></i>
            <h5 class="card-title">Email Concern</h5>
            <p class="card-text">
            <br>
            </p>
            <a href="password_reset" class="btn btn-xs">Request</a>
            <a href="status?type=Email Concern" class="custom-btn">
                <i class="fas fa-list-check"></i> Total: <?= $passresetCount; ?>
            </a>
        </div>
    </div>
</a>

<a href="deped_email" style="text-decoration: none; color: inherit;">
    <!-- DepEd Email Request -->
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-envelope icon"></i>
            <h5 class="card-title">DepEd Email Request</h5>
            <p class="card-text">
            <span class="badge badge-success">
                <?= ($em_count == 1) ? "Already Requested" : (($em_count == 0) ? "Not yet requested" : $em_count); ?>
            </span>
            </p>
            <a href="deped_email" class="btn btn-xs">Request</a>
            <a href="status?type=DepEd Email" class="custom-btn">
                <i class="fas fa-list-check"></i> view status
            </a>
        </div>
    </div>
</a>
   <!-- ID Card Printing -->
<!--a href="printing_id_card" style="text-decoration: none; color: inherit;">
 
    <div class="card">
        <div class="card-body text-center">
            <i class="fas fa-id-card icon"></i>
            <h5 class="card-title">ID Card Printing</h5>
            <p class="card-text">
            <span class="badge badge-success">
                <?= ($print_count == 1) ? "Already Requested" : (($print_count == 0) ? "Not yet requested" : $print_count); ?>
            </span>
            </p>
            <a href="printing_id_card" class="btn btn-xs">Request</a>
            <a href="status?type=ID Card Printing" class="custom-btn">
                <i class="fas fa-list-check"></i> view status
            </a>
        </div>
    </div>
</a-->
</div>

            </div>
            <div class="form-container_user">
                    <div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 15px;">
                        <button id="toggleCalendar" class="toggle-btn" 
                            style="position: absolute; left: 0; background-color: #007bff; color: white; border: none; padding: 4px 8px; font-size: 13px; border-radius: px; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-compress" style="margin-right: 3px;"></i> Minimize
                        </button>
                        <h1 style="margin: 0; text-align: center;">Request Status Calendar</h1>
                    </div>
                    <div class="calendar_container" style="margin-bottom: 3%;"> 
                            <hr>
                            <p style="text-align: center; font-size: 10px; color: #000;">Click on the event to see details.</p>
                        <div id="calendar">
                        </div>
                    </div>    
    </div>
<script>
$(document).ready(function () {
    let userId = "<?php echo $_SESSION['userId']; ?>";

fetch(`admin/query/fetch_calendar.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
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
                let mappedTitle = requestTypeMap[event.request_type_table] || "Unknown Request";
                return {
                    title: mappedTitle,
                    start: event.created_at,
                    request_id: event.request_id,
                    stat: event.stat,
                    description: event.request_type_table,
                    extendedProps: {
                        stat: event.stat,
                        remarks: event.remarks,
                        deadline: event.created_at,
                        request_id: event.request_id,
                        request_type: event.request_type_table // Keep original request type
                    },
                    backgroundColor: backgroundColor,
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
                        title: `<i class="fas fa-calendar-alt"></i> ${mappedRequestType}`,
                        html: `
                            <div style="padding: 15px; border-radius: 10px; background: #f8f9fa;">
                                <p><i class="fas fa-hashtag"></i> <b>ID:</b> ${info.event.extendedProps.request_id}</p>
                                <p><i class="fas fa-exclamation-circle"></i> <b>Status:</b> <span style="color: ${statusColor}; font-weight: bold;">${stat}</span></p>
                                <p><i class="fas fa-user"></i> <b>Remarks:</b> ${info.event.extendedProps.remarks ? info.event.extendedProps.remarks : "N/A"}</p>
                                <p><i class="fas fa-calendar-day"></i> <b>Date Requested:</b> ${formattedDeadline}</p>
                            </div>
                        `,
                        icon: "info",
                        showCloseButton: true,
                        confirmButtonText: '<i class="fas fa-eye"></i> View'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let requestId = info.event.extendedProps.request_id;
                            let redirectUrl = `status?request_id=${requestId}`;

        
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

        </div>
        
        <!-- Include jQuery and DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>    
<script src="asset/js/checkUnratedRequest.js"></script>
<script src="asset/js/toggle_navbar.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    </body>
    </html>