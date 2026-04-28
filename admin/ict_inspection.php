<?php       

include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/pending_navbar.php';
include 'query/ict_inspection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Equipment Inspection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_ict_inspection.css">
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
                    <a href="dashboard" >
                        <i class="fas fa-dashboard"></i> Dashboard
                    </a>
                    <a href="deped_email">
                        <i class="fas fa-envelope"></i> DepEd Email <span class="badge"><?= $pending_counts['deped_email_request'] ? $pending_counts['deped_email_request'] : 0 ?></span>
                    </a>
                    <a href="reset_email">
                        <i class="fas fa-key"></i> Email Concern <span class="badge"><?= $pending_counts['password_reset'] ? $pending_counts['password_reset'] : 0 ?></span>
                    </a>
                    <!--a href="id_card">
                        <i class="fas fa-id-card"></i> ID Card Requests <span class="badge"><?= $pending_counts['id_card_printing'] ? $pending_counts['id_card_printing'] :  0 ?></span>
                    </a-->
                    <a href="ict_maintenance">
                        <i class="fas fa-tools"></i> ICT Maintenance <span class="badge"><?= $pending_counts['ict_maintenance'] ? $pending_counts['ict_maintenance'] : 0 ?></span>
                    </a>
                    <!--a href="document">
                        <i class="fas fa-file-alt"></i> Documentation <span class="badge"><?= $pending_counts['documentation'] ? $pending_counts['documentation'] : 0 ?></span>
                    </a>
                    <a href="audio">
                        <i class="fas fa-video"></i> Audio Visual Editing <span class="badge"><?= $pending_counts['audio_visual_editing'] ? $pending_counts['audio_visual_editing'] : 0 ?></span>
                    </a-->
                    <a href="ict_inspection"  style="font-weight: bold; color:rgb(238, 108, 21);">
                        <i class="fas fa-search"></i> ICT Inspection <span class="badge"><?= $pending_counts['ict_equipment_inspection'] ? $pending_counts['ict_equipment_inspection'] : 0 ?></span>
                    </a>
                    <!--a href="software_request">
                        <i class="fas fa-code"></i> Software Development <span class="badge"><?= $pending_counts['software_development'] ? $pending_counts['software_development'] : 0 ?></span>
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

        <!-- Form Container -->
        <div class="form-container">
            <h1>ICT Equipment Inspection</h1>
            <hr>
            <!-- DataTable -->
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Item/Description</th>
                        <th>Property Number</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['request_id']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td>
                                    <?php 
                                        $item = htmlspecialchars($row['item']);
                                        $maxLength = 15; // Adjust this limit as needed

                                        if (!empty($item)) {
                                            if (strlen($item) > $maxLength) {
                                                $shortItem = substr($item, 0, $maxLength) . '';
                                                echo '<span class="short-text-item">' . $shortItem . '</span>';
                                                echo '<span class="full-text-item" style="display:none;">' . $item . '</span> ';
                                                echo '<a href="#" onclick="toggleText(this, \'item\'); return false;" 
                                                    style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                            } else {
                                                echo $item;
                                            }
                                        } else {
                                            echo "No Item";
                                        }
                                    ?>
                                </td>

                                <td><?= htmlspecialchars($row['property_no']) ?></td>
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
                                            data-remarks="<?= $row['remarks'] ?>"
                                            data-defects="<?= $row['defects'] ?>"
                                            data-findings="<?= $row['findings'] ?>"
                                            data-parts_repair_replace="<?= $row['parts_repair_replace'] ?>" 
                                            data-job_order_no="<?= $row['job_order_no'] ?>"
                                            data-amount="<?= $row['amount'] ?>"
                                            data-invoice_no="<?= $row['invoice_no'] ?>"
                                            data-comment_after_repair="<?= $row['comment_after_repair'] ?>"
                                            >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-delete" 
                                        data-request_id="<?= $row['request_id'] ?>" 
                                        data-id="<?= $row['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                        <button class="btn-view" onclick="view('<?=urlencode($row['request_id'])?>')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-print" onclick="print('<?=urlencode($row['request_id'])?>')">
                                            <i class="fas fa-print"></i>
                                        </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
    </div>

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

    $(".btn-edit").click(function () {
        var id = $(this).data("id");
        var request_id = $(this).data("request_id");
        var currentStatus = $(this).data("status") || "";
        var currentRemarks = $(this).data("remarks") || "";
        var defects = $(this).data("defects") || "";
        var findings = $(this).data("findings") || "";
        var parts_repair_replace = $(this).data("parts_repair_replace") || "";
        var job_order_no = $(this).data("job_order_no") || "";
        var amount = $(this).data("amount") || "";
        var invoice_no = $(this).data("invoice_no") || "";
        var comment_after_repair = $(this).data("comment_after_repair") || "";
        Swal.fire({
    title: "Update Status & Remarks",
    width: "80%", // Increase width (default is auto)
    customClass: {
        popup: "wide-swal", // Custom class for styling
    },
    html: `
 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; width: 100%;">
        <div>
            <label style="font-weight: bold;">Status</label>
            <select id="status" style="width: 100%; padding: 8px; margin-bottom: 20px;">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Rejected">Rejected</option>
            </select>

            <h3 style="color: #007bff; font-weight: bold;">🔍 Pre-Repair Inspection</h3>

            <label style="font-weight: bold;">Parts/Components to be Repaired/Replaced</label>
            <textarea id="parts_repair_replace" style="width: 95%; padding: 8px; height: 60px; margin-bottom: 20px;">${parts_repair_replace}</textarea>

            <label style="font-weight: bold;">Defects</label>
            <textarea id="defects" style="width: 95%; padding: 8px; height: 60px; margin-bottom: 20px;">${defects}</textarea>

            <label style="font-weight: bold;">Findings and Observations</label>
            <textarea id="findings" style="width: 95%; padding: 8px; height: 60px; margin-bottom: 20px;">${findings}</textarea>
        </div>

        <div>
            <label style="font-weight: bold;">Remarks</label>
            <textarea id="remarks" style="width: 95%; height: 30px; padding: 8px;" placeholder="Enter remarks...">${currentRemarks}</textarea>

            <h3 style="color: #28a745; font-weight: bold;">🛠️ Post-Repair Details</h3>

            <label style="font-weight: bold;">Job Order No.</label>
            <input type="text" id="job_order_no" value="${job_order_no}" style="width: 95%; padding: 8px; margin-bottom: 20px;">

            <label style="font-weight: bold;">Amount</label>
            <input type="text" id="amount" value="${amount}" style="width: 95%; padding: 8px; margin-bottom: 20px;">

            <label style="font-weight: bold;">Invoice No.</label>
            <input type="text" id="invoice_no" value="${invoice_no}" style="width: 95%; padding: 8px; margin-bottom: 20px;">

            <label style="font-weight: bold;">Comment After Repair</label>
            <textarea id="comment_after_repair" style="width: 95%; padding: 8px; height: 60px;">${comment_after_repair}</textarea>
        </div>
    </div>
    `,
    showCancelButton: true,
    confirmButtonText: "Update",
    preConfirm: () => {
        return {
            request_id: request_id,
            id: id,
            status: document.getElementById("status").value,
            remarks: document.getElementById("remarks").value,
            defects: document.getElementById("defects").value,
            findings: document.getElementById("findings").value,
            parts_repair_replace: document.getElementById("parts_repair_replace").value,
            job_order_no: document.getElementById("job_order_no").value,
            amount: document.getElementById("amount").value,
            invoice_no: document.getElementById("invoice_no").value,
            comment_after_repair: document.getElementById("comment_after_repair").value
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
    toggleFields(); // Set initial state based on current status

    document.getElementById("status").addEventListener("change", toggleFields);
}, 100);

function toggleFields() {
    const status = document.getElementById("status").value;
    const isCompleted = status === "Completed";

    const fields = ["job_order_no", "amount", "invoice_no", "comment_after_repair"];
    
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.readOnly = !isCompleted;
        field.style.backgroundColor = isCompleted ? "#ffffff" : "#e0e0e0"; // White when editable, gray when read-only
        field.style.cursor = isCompleted ? "text" : "not-allowed"; // Indicate it's disabled
        });
    }

 });

                $(".btn-delete").click(function () {
                    var row = $(this).closest("tr");
                    var request_id = $(this).data("request_id");
                    var id = $(this).data("id");

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
                                url: "", // Ensure this points to the correct PHP file
                                data: { request_id: request_id, id: id },
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
        $(document).ready(function() {
            var table = $('#example').DataTable({
                responsive: true, 
                autoWidth: false, 
                scrollX: true,
                lengthMenu: [5, 10, 25, 50, 100]
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
     <!-- Script to Toggle Notification Dropdown -->
     <script>
        function toggleNotification() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const icon = document.querySelector('.notification-icon');
            if (!dropdown.contains(event.target) && !icon.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
        function print(requestId) {
                window.open('print_ict_inspection?request_id=' + requestId, '_blank');
                }
        function view(requestId) {
                window.open('view_ict_inspection?request_id=' + requestId, '_blank');
                }
    </script>
</body>
</html>