<?php       
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/pending_navbar.php';
include 'query/software_request.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Development Requests</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_software_request.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/calendar.css">
    <link rel="stylesheet" href="../asset/css/profile_link.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <a class="navbar-brand" href="dashboard">
            <img src="../image/logo (1).png" alt="Logo"> <!-- Replace with your logo path -->
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
                    <a href="document">
                        <i class="fas fa-file-alt"></i> Documentation <span class="badge"><?= $pending_counts['documentation'] ? $pending_counts['documentation'] : 0 ?></span>
                    </a>
                    <a href="audio">
                        <i class="fas fa-video"></i> Audio Visual Editing <span class="badge"><?= $pending_counts['audio_visual_editing'] ? $pending_counts['audio_visual_editing'] : 0 ?></span>
                    </a>
                    <a href="ict_inspection" >
                        <i class="fas fa-search"></i> ICT Inspection <span class="badge"><?= $pending_counts['ict_equipment_inspection'] ? $pending_counts['ict_equipment_inspection'] : 0 ?></span>
                    </a>
                    <a href="software_request" style="font-weight: bold; color:rgb(238, 108, 21);">
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
            <h1>Software Development Requests</h1>
            <hr>
           <!-- DataTable -->
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>   
                    <th>ID</th>
                    <th>Name</th>
                    <th>Project Name</th>
                    <th>Brief Description</th>
                    <th>Project Deadline</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['request_id']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td>
                        <?php 
                            $projName = htmlspecialchars($row['proj_name']);
                            $maxLength = 10; // Adjust this limit as needed

                            if (!empty($projName)) {
                                if (strlen($projName) > $maxLength) {
                                    $shortProjName = substr($projName, 0, $maxLength) . '';
                                    echo '<span class="short-text-projname">' . $shortProjName . '</span>';
                                    echo '<span class="full-text-projname" style="display:none;">' . $projName . '</span> ';
                                    echo '<a href="#" onclick="toggleText(this, \'projname\'); return false;" 
                                        style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                } else {
                                    echo $projName;
                                }
                            } else {
                                echo "No Project Name";
                            }
                        ?>
                    </td>

                    <td>
                        <?php 
                            $briefDesc = htmlspecialchars($row['brief_desc']);
                            $maxLength = 20; // Adjust this limit as needed

                            if (!empty($briefDesc)) {
                                if (strlen($briefDesc) > $maxLength) {
                                    $shortBriefDesc = substr($briefDesc, 0, $maxLength) . '';
                                    echo '<span class="short-text-briefdesc">' . $shortBriefDesc . '</span>';
                                    echo '<span class="full-text-briefdesc" style="display:none;">' . $briefDesc . '</span> ';
                                    echo '<a href="#" onclick="toggleText(this, \'briefdesc\'); return false;" 
                                        style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                } else {
                                    echo $briefDesc;
                                }
                            } else {
                                echo "No Description";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            $projDeadline = htmlspecialchars($row['proj_deadline']);
                            if (!empty($projDeadline)) {
                                $formattedDate = date("l • F j, Y • g:i a", strtotime($projDeadline));
                                echo $formattedDate;
                            } else {
                                echo "No Deadline";
                            }
                        ?>
                    <td class="status" style="
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
                                                    style="text-decoration: none; font-size: 25px; cursor: pointer;">
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
                            data-request_id="<?= $row['request_id'] ?>" 
                            data-id="<?= $row['id'] ?>" 
                            data-status="<?= $row['stat'] ?>" 
                            data-remarks="<?= $row['remarks'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" 
                            data-request_id="<?= $row['request_id'] ?>" 
                            data-idd="<?= $row['id'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                        <a href="view_software_request?request_id=<?=urlencode($row['request_id'])?>">
                            <button class="btn-view">
                                <i class="fas fa-eye"></i>
                            </button>
                        </a>
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
    function fetchAndRenderCalendar(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let events = data.map(event => {
                    let statusColor = {
                        "Pending": "#f9aa0b", // Yellow
                        "In Progress": "#0a72cf", // Blue
                        "Completed": "#358308", // Green
                        "Rejected": "#ec160b"  // Red
                    };

                    return {
                        title: event.title || event.proj_name,
                        email: event.fullname,
                        request_id: event.request_id,
                        stat: event.stat,
                        description: event.details || event.proj_desc || event.brief_desc,
                        start: event.event_date ? new Date(event.event_date + "T" + event.start_time) : event.project_deadline || event.proj_deadline,
                        end: event.end_time ? new Date(event.event_date + "T" + event.end_time) : null,
                        backgroundColor: statusColor[event.stat] || "#95a5a6", // Default Gray if status unknown
                        extendedProps: {
                            deadline: event.project_deadline || event.proj_deadline
                        }
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


    let statusColors = {
        "Pending": "#f9aa0b", 
        "In Progress": "#0a72cf",
        "Completed": "#358308", 
        "Rejected": "#ec160b" 
    };

    let statusColor = statusColors[stat] || "#95a5a6"; 
    let requestId = info.event.extendedProps.request_id;
    let formattedDeadline = info.event.extendedProps.deadline ? 
        new Date(info.event.extendedProps.deadline).toLocaleString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: true
        }) : "No Deadline";

    Swal.fire({
        title: `<i class="fas fa-calendar-alt"></i> ${info.event.title}`,
        html: `
            <div style="padding: 15px; border-radius: 10px; background: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <p><i class="fas fa-exclamation-circle"></i> <b>Status:</b> <span style="color: ${statusColor}; font-weight: bold;">${stat}</span></p>
                <p><i class="fas fa-user"></i> <b>Name:</b> ${info.event.extendedProps.email}</p>
                <p><i class="fas fa-align-left"></i> <b>Description:</b> ${info.event.extendedProps.description}</p>
                <p><i class="fas fa-calendar-day"></i> <b>Project Deadline:</b> ${formattedDeadline}</p>
            </div>
        `,
        icon: 'info',
        showConfirmButton: true,
        showCloseButton: true,
        showCloesButton: true,
        confirmButtonText: '<i class="fas fa-eye"></i> View'
    }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = `software_request?request_id=${requestId}`;
                                                }
                                            });
},


                    dateClick: function (info) {
                        calendar.changeView('timeGridDay', info.dateStr);
                    }
                });

                calendar.render();
            })
            .catch(error => console.error("Error fetching events:", error));
    }
    let requestType = "software_development";             

    fetchAndRenderCalendar("query/fetch_calendar.php?type=" + requestType);
});

                </script>


    <!-- jQuery and DataTables JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
                function toggleRemarks(link) {
                    var shortText = link.parentNode.querySelector('.short-text_remarks');
                    var fullText = link.parentNode.querySelector('.full-text_remarks');

                    if (shortText.style.display === 'none') {
                        shortText.style.display = 'inline';
                        fullText.style.display = 'none';
                        link.textContent = '...'; // Show ellipsis when collapsed
                    } else {
                        shortText.style.display = 'none';
                        fullText.style.display = 'inline';
                        link.textContent = '↖'; // Show small arrow when expanded
                    }
                }
                function toggleText(link, type) {
                    var shortText = link.parentNode.querySelector('.short-text-' + type);
                    var fullText = link.parentNode.querySelector('.full-text-' + type);

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
    // Initialize DataTable

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


    $(".btn-edit").click(function () {
        var row = $(this).closest("tr");
        var id = $(this).data("id");
        var request_id = $(this).data("request_id");
        var currentStatus = $(this).data("status");
        var currentRemarks = $(this).data("remarks");

        Swal.fire({
            title: "Update Status & Remarks",
            html: `
                <div style="text-align: left; width: 100%;">
                    <label style="font-weight: bold;">Status</label>
                    <select id="status" style="width: 100%; padding: 8px; margin-bottom: 20px;">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    <label style="font-weight: bold;">Remarks</label>
                    <textarea id="remarks" style="width: 100%; height: 80px;" placeholder="Enter remarks...">${currentRemarks}</textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Update",
            preConfirm: () => {
                return {
                    request_id: request_id,
                    id: id,
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
                        if (response.success) {
                            Swal.fire("Deleted!", "Record has been deleted.", "success")
                                .then(() => row.fadeOut(300, function () { $(this).remove(); }));
                        } else {
                            Swal.fire("Error!", "Failed to delete record: " + (response.error || "Unknown error"), "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire("Error!", "Server error while deleting record: " + error, "error");
                        console.log("AJAX Error: ", xhr.responseText);
                    }
                });
            }
        });
    });
});
</script>
    <script>

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>