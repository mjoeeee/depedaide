<?php
include '../all_function.php';
include 'not_admin.php';
include '../config.php';
include 'query/pending_navbar.php';
include 'query/reset_email.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset DepEd Email</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/admin_reset_email.css">
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
                    <a href="reset_email" style="font-weight: bold; color:rgb(238, 108, 21);">
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
                    <a href="ict_inspection" >
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
            <h1>DepEd Email Concern</h1>
            <hr>
            <!-- DataTable -->
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DepEd Email</th>
                        <th>Reason</th>
                        <th>Screenshot</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['request_id']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <?php 
                                    $reason = htmlspecialchars($row['reason']);
                                    $maxLength = 8;

                                    if (!empty($reason)) { // Fix: Use $reason instead of $remarks
                                        if (strlen($reason) > $maxLength) {
                                            $shortreason = substr($reason, 0, $maxLength) . '';
                                            echo '<span class="short-text-reason">' . $shortreason . '</span>';
                                            echo '<span class="full-text-reason" style="display:none;">' . $reason . '</span> ';
                                            echo '<a href="#" onclick="togglereason(this); return false;" 
                                                style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
                                        } else {
                                            echo $reason;
                                        }
                                    } else {
                                        echo "No Reason";
                                    }
                                ?>
                            </td>

                           <td>
    <img src="../<?= htmlspecialchars($row['attachment']) ?>"
         alt="No attachment"
         class="screenshot-img preview-image"
         style="width: 100px; height: auto; cursor: pointer;"
         data-full-image="../image/<?= htmlspecialchars($row['attachment']) ?>"
         onerror="this.onerror=null;
                  this.src='../image/no-image.png';
                  this.dataset.fullImage='../image/no-image.png';">
</td>

                            <td style="
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
                                                        $shortRemarks = substr($remarks, 0, $maxLength);
                                                        echo '<span class="short-text">' . $shortRemarks . '</span>';
                                                        echo '<span class="full-text" style="display:none;">' . $remarks . '</span> ';
                                                        echo '<a href="#" onclick="toggleRemarks(this); return false;" 
                                                            style="text-decoration: none; font-size: 25px; cursor: pointer;">...</a>';
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
            <script>
                    function toggleRemarks(link) {
                        var shortText = link.parentNode.querySelector('.short-text');
                        var fullText = link.parentNode.querySelector('.full-text');

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
                    function togglereason(link) {
                        var shortText = link.parentNode.querySelector('.short-text-reason');
                        var fullText = link.parentNode.querySelector('.full-text-reason');

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

                </script>
            <!-- Image Preview Modal -->
            <div id="imageModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);">
                <span class="close-modal" style="position: absolute; top: 15px; right: 25px; font-size: 35px; color: white; cursor: pointer;">&times;</span>
                <img id="modalImage" style="display: block; margin: auto; max-width: 90%; max-height: 90%; padding-top: 50px;">
            </div>
        </div>
    </div>

    <!-- jQuery and DataTables JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
  $(document).ready(function () {

                            $(".btn-edit").click(function () {
                                var row = $(this).closest("tr");
                                var request_id = $(this).data("id");
                                var currentStatus = $(this).data("status"); // Status column
                                var currentRemarks = $(this).data("remarks"); // Remarks column

                                Swal.fire({
                                    title: "Update Status & Remarks",
                                    html: `
                                        <div style="text-align: left; width: 100%;">
                                            <label style="font-weight: bold;">Status</label>
                                            <select id="status" style="width: 100%; padding: 8px;">
                                                <option value="Pending">Pending</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>

                                            <label style="font-weight: bold; margin-top: 10px;">Remarks</label>
                                            <textarea id="remarks" style="width: 100%; height: 80px;" placeholder="Enter remarks...">${currentRemarks}</textarea>

                                        </div>
                                    `,
                                    showCancelButton: true,
                                    confirmButtonText: "Update",
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
                                        url: "", // Ensure this points to the correct PHP file
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
        document.addEventListener("DOMContentLoaded", function () {
            let modal = document.getElementById("imageModal");
            let modalImg = document.getElementById("modalImage");
            let closeModal = document.querySelector(".close-modal");

            document.querySelectorAll(".preview-image").forEach(img => {
                img.addEventListener("click", function () {
                    modal.style.display = "block";
                    modalImg.src = this.getAttribute("data-full-image");
                });
            });

            closeModal.addEventListener("click", function () {
                modal.style.display = "none";
            });

            modal.addEventListener("click", function (e) {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
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
</body>
</html>