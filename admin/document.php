<?php       
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/pending_navbar.php';
include 'query/document.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage documentation</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_document.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/calendar.css">
    <link rel="stylesheet" href="../asset/css/profile_link.css">
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

    <!-- Container for Sidebar and Content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
        <div class="profile-container">
                <h3 class="profile-link">
                <i class="fas fa-user-shield me-1"></i>
                    <?php echo $_SESSION['fullname']; ?>
                </h3>
            </div>
        <div>
                <a href="dashboard">
                    <i class="fas fa-dashboard"></i> Dashboard
                </a>
                <a href="deped_email">
                        <i class="fas fa-envelope"></i> DepEd Email <span class="badge"><?= $pending_counts['deped_email_request'] ? $pending_counts['deped_email_request'] : 0 ?></span>
                    </a>
                    <a href="reset_email">
                        <i class="fas fa-key"></i> Email Concern <span class="badge"><?= $pending_counts['password_reset'] ? $pending_counts['password_reset'] : 0 ?></span>
                    </a>
                    <a href="id_card">
                        <i class="fas fa-id-card"></i> ID Card Requests <span class="badge"><?= $pending_counts['id_card_printing'] ? $pending_counts['id_card_printing'] :  0 ?></span>
                    </a>
                    <a href="ict_maintenance">
                        <i class="fas fa-tools"></i> ICT Maintenance <span class="badge"><?= $pending_counts['ict_maintenance'] ? $pending_counts['ict_maintenance'] : 0 ?></span>
                    </a>
                    <a href="document"  style="font-weight: bold; color:rgb(238, 108, 21);">
                        <i class="fas fa-file-alt"></i> Documentation <span class="badge"><?= $pending_counts['documentation'] ? $pending_counts['documentation'] : 0 ?></span>
                    </a>
                    <a href="audio">
                        <i class="fas fa-video"></i> Audio Visual Editing <span class="badge"><?= $pending_counts['audio_visual_editing'] ? $pending_counts['audio_visual_editing'] : 0 ?></span>
                    </a>
                    <a href="ict_inspection">
                        <i class="fas fa-search"></i> ICT Inspection <span class="badge"><?= $pending_counts['ict_equipment_inspection'] ? $pending_counts['ict_equipment_inspection'] : 0 ?></span>
                    </a>
                    <a href="software_request">
                        <i class="fas fa-code"></i> Software Development <span class="badge"><?= $pending_counts['software_development'] ? $pending_counts['software_development'] : 0 ?></span>
                    </a> 
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

        <!-- Form Container -->
        <div class="form-container">
            <h1>Documentation Data</h1>
            <hr>
            <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Event Title</th>
                            <th>Location of Event</th>
                            <th>Event Date/Time</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['request_id']) ?></td>
                                <td><?= htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php 
                                        $title = htmlspecialchars($row['title']);
                                        $maxLength = 10; // Adjust this if needed

                                        if (!empty($title)) {
                                            if (strlen($title) > $maxLength) {
                                                $shortTitle = substr($title, 0, $maxLength) . '';
                                                echo '<span class="short-text-title">' . $shortTitle . '</span>';
                                                echo '<span class="full-text-title" style="display:none;">' . $title . '</span> ';
                                                echo '<a href="#" onclick="toggleTitle(this); return false;" 
                                                    style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                            } else {
                                                echo $title;
                                            }
                                        } else {
                                            echo "No Title";
                                        }
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $eventLocation = htmlspecialchars($row['event_location']);
                                        $maxLength = 10; // Adjust as needed

                                        if (!empty($eventLocation)) {
                                            if (strlen($eventLocation) > $maxLength) {
                                                $shortLocation = substr($eventLocation, 0, $maxLength) . '';
                                                echo '<span class="short-text-location">' . $shortLocation . '</span>';
                                                echo '<span class="full-text-location" style="display:none;">' . $eventLocation . '</span> ';
                                                echo '<a href="#" onclick="toggleLocation(this); return false;" 
                                                    style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                            } else {
                                                echo $eventLocation;
                                            }
                                        } else {
                                            echo "No Location";
                                        }
                                    ?>
                                </td>

                                <td><?= date("F j, Y", strtotime($row['event_date'])) ?>
                                        •   
                                    <?= date("g:i A", strtotime($row['start_time'])) ?> - 
                                    <?= date("g:i A", strtotime($row['end_time'])) ?>
                                </td>
                                <td>
                                    <?php 
                                    $details = htmlspecialchars($row['details']);
                                    $maxLength = 10;

                                    if (!empty($details)) {
                                        if (strlen($details) > $maxLength) {
                                            $shortDetails = substr($details, 0, $maxLength) . "";
                                            echo '<span class="short-text_details">' . $shortDetails . '</span>';
                                            echo '<span class="full-text_details" style="display:none;">' . $details . '</span>';
                                            echo ' <a href="#" onclick="toggleDetails(this); return false;" 
                                                    style="text-decoration: none; font-size: 25px; cursor: pointer;">
                                                    ...
                                                </a>';
                                        } else {
                                            echo $details;
                                        }
                                    } else {
                                        echo "No details yet";
                                    }
                                    ?>
                                </td>
                                <td class="status"style="
                                    font-weight:bold;
                                    padding: 5px 10px; 
                                    border-radius: 5px; 
                                    text-align: center; 
                                    color:
                                    <?php 
                                        switch (strtolower($row['stat'])) {
                                            case 'pending': echo '#f9aa0b'; break;
                                            case 'in progress': echo '#0a72cf'; break;
                                            case 'completed': echo '#358308'; break;
                                            case 'rejected': echo '#ec160b'; break;
                                            default: echo 'gray'; // Default color for unknown statuses
                                        }
                                    ?>;"><?= htmlspecialchars($row['stat']) ?></td>
                                <td>
                                    <?php 
                                    $remarks = htmlspecialchars($row['remarks']);
                                    $maxLength = 8;

                                    if (!empty($remarks)) {
                                        if (strlen($remarks) > $maxLength) {
                                            $shortRemarks = substr($remarks, 0, $maxLength) . "";
                                            echo '<span class="short-text_remarks">' . $shortRemarks . '</span>';
                                            echo '<span class="full-text_remarks" style="display:none;">' . $remarks . '</span>';
                                            echo ' <a href="#" onclick="toggleRemarks(this); return false;" 
                                                    style="text-decoration: none; font-size: 25px;  cursor: pointer;">
                                                    ...
                                                </a>';
                                        } else {
                                            echo $remarks;
                                        }
                                    } else {
                                        echo "No Remarks Yet";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn-edit"     
                                        data-id="<?= $row['request_id'] ?>" 
                                        data-status="<?= $row['stat'] ?>" 
                                        data-remarks="<?= $row['remarks'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-delete" 
                                        data-request_id="<?= $row['request_id'] ?>" 
                                        data-idd="<?= $row['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
                <div class="form-container">
                    <div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 15px;">
                        <button id="toggleCalendar" class="toggle-btn" 
                        style="position: absolute; left: 0; background-color: #007bff; color: white; border: none; padding: 4px 8px; font-size: 13px; border-radius: px; cursor: pointer; transition: all 0.3s ease;">
                        <i class="fas fa-compress" style="margin-right: 3px;"></i> Minimize
                        </button>
                        <h1 style="margin: 0; text-align: center;">Event Calendar</h1>
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

                            let requestType = "documentation";
                            
                            fetch("query/fetch_calendar.php?type=" + requestType) 
                                    .then(response => response.json())
                                    .then(data => {
                                        let events = data.map(event => ({
                                            title: event.title,
                                            fullname: event.fullname,
                                            stat: event.stat,
                                            request_id: event.request_id,
                                            description: event.details,
                                            start: new Date(event.event_date + "T" + event.start_time),
                                            end: event.end_time ? new Date(event.event_date + "T" + event.end_time) : null,
                                            backgroundColor: getStatusColor(event.stat),
                                            borderColor: getStatusColor(event.stat)
                                        }));

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

                                            eventClick: function(info) {
                                            let stat = info.event.extendedProps.stat;
                                            let optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                            let optionsTime = { hour: 'numeric', minute: 'numeric', hour12: true };
                                            let formattedDate = info.event.start.toLocaleDateString('en-US', optionsDate);
                                            let formattedStartTime = info.event.start.toLocaleTimeString('en-US', optionsTime);
                                            let formattedEndTime = info.event.end ? info.event.end.toLocaleTimeString('en-US', optionsTime) : "N/A";

                                            let statusColors = {
                                                "Pending": "#f9aa0b", // Yellow
                                                "In Progress": "#0a72cf", // Blue
                                                "Completed": "#358308", // Green
                                                "Rejected": "#ec160b"  // Red
                                            };

                                            let statusColor = statusColors[stat] || "#95a5a6";
                                            let requestId = info.event.extendedProps.request_id; // Ensure the request_id is part of event data

                                            Swal.fire({
                                                title: `<i class="fas fa-calendar-alt"></i> ${info.event.title}`,
                                                html: `
                                                    <div style="padding: 15px; border-radius: 10px; background: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                                        <p><i class="fas fa-exclamation-circle"></i> <b>Status:</b> <span style="color: ${statusColor}; font-weight: bold;">${stat}</span></p>
                                                        <p><i class="fas fa-user"></i> <b>Organizer:</b> ${info.event.extendedProps.fullname}</p>
                                                        <p><i class="fas fa-align-left"></i> <b>Description:</b> ${info.event.extendedProps.description}</p>
                                                        <p><i class="fas fa-calendar-day"></i> <b>Date:</b> ${formattedDate}</p>
                                                        <p><i class="fas fa-clock"></i> <b>Time:</b> ${formattedStartTime} - ${formattedEndTime}</p>
                                                    </div>
                                                `,
                                                icon: 'info',
                                                showConfirmButton: true,
                                                showCloseButton: true,
                                                confirmButtonText: '<i class="fas fa-eye"></i> View',
                                                customClass: {
                                                    popup: 'custom-swal-popup',
                                                    title: 'custom-swal-title'
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = `document?request_id=${requestId}`;
                                                }
                                            });
                                        },


                                            dateClick: function(info) {
                                                calendar.changeView('timeGridDay', info.dateStr);
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

                            function getStatusColor(status) {
                                switch (status.toLowerCase()) {
                                    case "pending": return "#f9aa0b";  // Yellow
                                    case "in progress": return "#0a72cf";  // Blue
                                    case "completed": return "#358308";  // Green
                                    case "rejected": return "#ec160b";  // Red
                                    default: return "gray";  
                                }
                            }
    </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
                function toggleDetails(link) {
                            var shortText = link.parentNode.querySelector('.short-text_details');
                            var fullText = link.parentNode.querySelector('.full-text_details');

                            if (shortText.style.display === 'none') {
                                shortText.style.display = 'inline';
                                fullText.style.display = 'none';
                                link.innerHTML = '<span style="font-size: 25px">...</span>'; // Adjust size here
                            } else {
                                shortText.style.display = 'none';
                                fullText.style.display = 'inline';
                                link.innerHTML = '<span style="font-size: 25px;">↖</span>'; // Adjust size here
                            }
                        }
                function toggleRemarks(link) {
                        var shortText = link.parentNode.querySelector('.short-text_remarks');
                        var fullText = link.parentNode.querySelector('.full-text_remarks');

                        if (shortText.style.display === 'none') {
                                shortText.style.display = 'inline';
                                fullText.style.display = 'none';
                                link.innerHTML = '<span style="font-size: 25px">...</span>'; // Adjust size here
                            } else {
                                shortText.style.display = 'none';
                                fullText.style.display = 'inline';
                                link.innerHTML = '<span style="font-size: 25px;">↖</span>'; // Adjust size here
                            }
                    
                        }
                function toggleLocation(link) {
                            var shortText = link.parentNode.querySelector('.short-text-location');
                            var fullText = link.parentNode.querySelector('.full-text-location');

                            if (shortText.style.display === 'none') {
                                shortText.style.display = 'inline';
                                fullText.style.display = 'none';
                                link.innerHTML = '<span style="font-size: 25px;">...</span>';
                            } else {
                                shortText.style.display = 'none';
                                fullText.style.display = 'inline';
                                link.innerHTML = '<span style="font-size: 25px;">↖</span>';
                            }
                        }
                function toggleTitle(link) {
                            var shortText = link.parentNode.querySelector('.short-text-title');
                            var fullText = link.parentNode.querySelector('.full-text-title');

                            if (shortText.style.display === 'none') {
                                shortText.style.display = 'inline';
                                fullText.style.display = 'none';
                                link.innerHTML = '<span style="font-size: 25px;">...</span>';
                            } else {
                                shortText.style.display = 'none';
                                fullText.style.display = 'inline';
                                link.innerHTML = '<span style="font-size: 25px;">↖</span>';
                            }
                        }

    $(document).ready(function () {
        $(".btn-edit").click(function () {
                    var row = $(this).closest("tr");
                    var request_id = $(this).data("id");
                    var currentStatus = $(this).data("status");
                    var currentRemarks = $(this).data("remarks");


                    Swal.fire({
                        title: "Update Status & Remarks",
                        html: `
                            <div style="text-align: left; width: 100%;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Status</label>
                                <select id="status" style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; outline: none;">
                                    <option value="Pending">Pending</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Rejected">Rejected</option>
                                </select>

                                <label style="font-weight: bold; display: block; margin-top: 10px; margin-bottom: 5px;">Remarks</label>
                                <textarea id="remarks" style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; outline: none; height: 80px;" placeholder="Enter remarks...">${currentRemarks}</textarea>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: "Update",
                        width: 'auto',
                        preConfirm: () => {
                            return {
                                request_id: request_id,
                                status: document.getElementById("status").value,
                                remarks: document.getElementById("remarks").value
                            };
                        }
                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            Swal.fire({
                                                title: 'Updating...',
                                                text: 'Please wait while the request is being updated and the email is being sent.',
                                                didOpen: () => {
                                                    Swal.showLoading(); 
                                                    const emailSendingAnimation = `
                                                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem; margin: 10px auto; display: block;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <p>Sending Email...</p>
                                                    `;
                                                    Swal.getContent().innerHTML += emailSendingAnimation; 
                                                },
                                                allowOutsideClick: false, 
                                            });

                                        $.post("", result.value, function(response) {
                                            Swal.fire({
                                                title: "Record updated successfully!",
                                                html: `
                                                    <p style="margin-top: 10px;">📧 <strong>Email Sent!</strong> An email has been sent to the user regarding the update.</p>
                                                `,
                                                icon: "success",
                                                timer: 2000,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
                                        }).fail(() => {
                                            Swal.fire("Error!", "Failed to update record.", "error");
                                        });

                                        }
                                    });
                                    setTimeout(() => {
                                        document.getElementById("status").value = currentStatus;
                                    }, 100);
                                });

        $(".btn-delete").click(function () {
                    var row = $(this).closest("tr");
                    var request_id = $(this).data("request_id");
                    var idd = $(this).data("idd");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This record will be permanently deleted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                    type: "POST",
                    url: "", 
                    data: { request_id: request_id, idd: idd },
                    dataType: "json",
                    success: function (response) {
                        if (response.success === true) {
                            Swal.fire("Deleted!", "Record has been deleted.", "success").then(() => {
                                row.fadeOut(300, function () { $(this).remove(); }); // Smoothly remove the row
                            });
                        } else {
                            console.error("Deletion failed:", response.error); //
                                        Swal.fire("Error!", "Failed to delete record: " + (response.error || "Unknown error"), "error");
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error("AJAX error:", error); // Log error for debugging
                                    Swal.fire("Error!", "Failed to delete record due to a server error.", "error");
                                }
                            });
                        }
                    });
                });

    });
</script>
    <script>
        $(document).ready(function() {
               var table = $('#example').DataTable({
                    responsive: true, 
                    autoWidth: false, 
                    scrollX: true,
                    lengthMenu: [5, 10, 25, 50, 100],
                });

        const urlParams = new URLSearchParams(window.location.search);
                        const requestId = urlParams.get('request_id');                        

                        if (requestId) {
                            table.search(decodeURIComponent(requestId)).draw();
                        }

                });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>