<?php
include 'all_function.php';
include 'config.php'; 
include 'query/status.php'; 
?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DepAIDE</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
        <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
        <link rel="stylesheet" href="asset/css/user_status.css">       
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar-custom">
                <a class="navbar-brand" href="dashboard">
                        <img src="image/logo (1).png" alt="Logo"> 
                    </a>
                    <div class="burger-menu" onclick="toggleSidebar()">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>

        </nav>


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
            <?php
            $requestTypeMap = array(
                'ict_maintenance' => 'ICT Maintenance',
                'software_development' => 'Software Development',
                'ict_equipment_inspection' => 'ICT Equipment Inspection',
                'documentation' => 'Documentation',
                'audio_visual_editing' => 'Audio Visual Editing',
                'deped_email_request' => 'DepEd Email',
                'password_reset' => 'Email Concern',
                'id_card_printing' => 'ID Card Printing',
            );
            ?>

<div class="form-container">
    <h1>Employee Service Request</h1>
    <hr>
    <div class="table-responsive">
        <table id="requestTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Action</th>
                    <th>ID</th>
                    <th>Type of Request</th>
                    <th>Date of Request</th>
                    <th style="display:none;">Updated At</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $row) : ?>
                <tr data-request-id="<?= htmlspecialchars($row['request_id']); ?>">
                    <td class='text-center'>
                        <a href="<?= ($row['request_type_table'] === "id_card_printing") ? "printing_id_card" : "#" ?>" 
                            style="text-decoration: none; font-size: 18px; <?= ($row['request_type_table'] === "id_card_printing") ? 'color: #dc3545;' : 'display: none;' ?> margin-left: 8px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "audio_visual_editing") ? 'view_audio?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "audio_visual_editing") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "ict_equipment_inspection") ? 'view_ict_inspection?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "ict_equipment_inspection") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "ict_maintenance") ? 'view_ict_maintenance?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "ict_maintenance") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "software_development") ? 'view_software_request?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "software_development") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "password_reset") ? 'view_email_concern?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "password_reset") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= ($row['request_type_table'] === "documentation") ? 'view_documentation?request_id=' . $row['request_id'] : '#' ?>" 
                            style="text-decoration: none; font-size: 18px; margin-left: 8px; <?= ($row['request_type_table'] === "documentation") ? 'color: #dc3545;' : 'display: none;' ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($row['stat'] === "Completed") : ?>
                            <a href="#" 
                                onclick="showRatingPopup('<?= htmlspecialchars($row['request_type_table']); ?>', '<?= htmlspecialchars($row['request_id']); ?>', '<?= htmlspecialchars($row['rated']); ?>'); return false;" 
                                style="text-decoration: none; font-size: 18px; margin-left: 8px; color: <?= ($row['rated'] == 1) ? '#358308' : '#dc3545'; ?>; <?= ($row['request_type_table'] == 'deped_email_request') ? 'margin-left: 38px;' : ''; ?>;">
                                <i class="fas fa-star"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['request_id']); ?></td>
                    <td><?= htmlspecialchars(isset($requestTypeMap[$row['request_type_table']]) ? $requestTypeMap[$row['request_type_table']] : 'Unknown Request'); ?></td>
                    <td>
                        <?= date("m/d/Y • g:i A", strtotime($row['created_at'])); ?>
                    </td>
                    <td  style="display:none;">
                        <?= date("m/d/Y • g:i A", strtotime($row['updated_at'])); ?>
                    </td>
                    <td style="
                        font-weight:bold;
                        padding: 5px 10px; 
                        border-radius: 5px; 
                        color:
                        <?php 
                            switch (strtolower($row['stat'])) {
                                case 'pending': echo '#f9aa0b'; break;
                                case 'in progress': echo '#0a72cf'; break;
                                case 'completed': echo '#358308'; break;
                                case 'rejected': echo '#ec160b'; break;
                                default: echo 'gray'; // Default color for unknown statuses
                            }
                        ?>;">
                        <?= htmlspecialchars($row['stat']); ?>
                    </td>
                    <td>
                        <?php 
                            $remarks = htmlspecialchars($row['remarks']);
                            $maxLength = 10;

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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
        <script>
            function toggleRemarks(link) {
                var shortText = link.parentNode.querySelector('.short-text');
                var fullText = link.parentNode.querySelector('.full-text');

                if (shortText.style.display === 'none') {
                    shortText.style.display = 'inline';
                    fullText.style.display = 'none';
                    link.innerHTML = '<span style="font-size: 25px">...</span>'; 
                } else {
                    shortText.style.display = 'none';
                    fullText.style.display = 'inline';
                    link.innerHTML = '<span style="font-size: 25px;">↖</span>'; 
                }
            }
        </script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
function showRatingPopup(requestType, requestId, rated) {
    const requestTypeMap = {
        'ict_maintenance': 'ICT Maintenance',
        'software_development': 'Software Development',
        'ict_equipment_inspection': 'ICT Equipment Inspection',
        'documentation': 'Documentation',
        'audio_visual_editing': 'Audio Visual Editing',
        'deped_email_request': 'DepEd Email',
        'password_reset': 'Email Concern',
        'id_card_printing': 'ID Card Printing'
    };

    const mappedRequestType = requestTypeMap[requestType] || 'Unknown Request Type';
    const ratedStatus = rated == 1 ? 'Rated' : 'Not Rated';
    const ratingLink = 'https://forms.office.com/pages/responsepage.aspx?id=gKvjQCQgo0W_dnoHYaJNKWgIw6RkFhNJi7IW9oBkiLxUOTVNWkg5NkxFWlpDNzlWMjY2WDZGVjNXNi4u&route=shorturl';
    const qrCodeContainer = document.createElement('div');
    
    QRCode.toDataURL(ratingLink, function (err, url) {
                        if (err) throw err;

                        Swal.fire({
                            title: rated == 1 ? 'Thank you for providing your rating!' : 'Kindly provide your rating.',
                            html: `
                                <div style="text-align: left; font-family: Arial, sans-serif; padding: 20px;">
                                    <!-- Request Type, Request ID, Rate Status in a row using Flexbox -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                        <div style="flex: 1; display: flex; align-items: center; margin-right: 15px;">
                                            <i class="fas fa-cogs" style="font-size: 20px; color: #dc3545; margin-right: 8px;"></i>
                                            <p style="font-size: 16px; color: #555; margin: 0;">${mappedRequestType}</p>
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center; margin-right: 15px;">
                                            <i class="fas fa-id-badge" style="font-size: 20px; color: #dc3545; margin-right: 8px;"></i>
                                            <p style="font-size: 16px; color: #555; margin: 0;">${requestId}</p>
                                        </div>
                                        <div style="flex: 1; display: flex; align-items: center;">
                                            <i class="fas fa-star" style="font-size: 20px; color: ${rated == 1 ? '#358308' : '#ec160b'}; margin-right: 8px;"></i>
                                            <p style="font-size: 16px; color: ${rated == 1 ? '#358308' : '#ec160b'}; font-weight: bold; margin: 0;">
                                                ${rated == 1 ? 'Rated' : 'Not Rated'}
                                            </p>
                                        </div>
                                    </div>
                                    <div style="text-align: center; margin-bottom: 15px;">
                                        <p style="font-size: 16px; color: #555;">Click the button to leave a rating:</p>
                                        <div style="margin: 10px 0;">
                                            ${qrCodeContainer.outerHTML}
                                        </div>
                                    </div>
                                    <div style="text-align: center;">
                                        <a href="${ratingLink}" target="_blank" class="swal2-confirm swal2-styled" 
                                        style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; 
                                        text-decoration: none; font-size: 16px; display: inline-block; margin-top: 10px;" 
                                        onclick="updateRatedColumn('${requestId}');">Open Rating Link</a>
                                    </div>
                                </div>
                            `,
                            showCancelButton: false,
                            showConfirmButton: false,
                            showCloseButton: true
                        });
                    });
                }

            function updateRatedColumn(requestId) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'query/update_rated.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                location.reload();  
                            }
                        };

                        xhr.send('requestId=' + encodeURIComponent(requestId));
                    }


            function cancelRequest(element) {
                        var row = $(element).closest('tr');
                        var requestId = row.data('request-id'); 
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to cancel this request?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, cancel it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: window.location.href, 
                                    type: 'POST',
                                    data: { id: requestId },
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            Swal.fire('Cancelled!', response.message, 'success');
                                            row.fadeOut(300, function () { $(this).remove(); }); 
                                        } else {
                                            Swal.fire('Error!', response.message, 'error');
                                        }
                                    },
                                    error: function () {
                                        Swal.fire('Error!', 'There was an error cancelling your request.', 'error');
                                    }
                                });
                            }
                        });
                    }
     
                    $(document).ready(function () {
                        var table = $('#requestTable').DataTable({
                            "paging": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "lengthMenu": [10, 25, 50],
                            "columnDefs": [
                                { "orderable": false, "targets": 0 },  // Disable sorting for the action column
                                { "visible": false, "targets": 4 }  // Hide the 'updated_at' column (index 4)
                            ],
                            "order": [[4, 'desc']],  // Sort by the 'updated_at' column (index 4)
                        });

                        const urlParams = new URLSearchParams(window.location.search);
                        const requestType = urlParams.get('type');
                        const requestId = urlParams.get('request_id');
                        
                        if (requestType) {
                            table.search(decodeURIComponent(requestType)).draw();
                        }
                        if (requestId) {
                            table.search(decodeURIComponent(requestId)).draw();
                        }

                        table.rows().every(function () {
                            var data = this.data(); 
                            var updatedAt = data[4]; // 'updated_at' is at index 4
                        });
                    });
            </script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>    
        <script src="asset/js/checkUnratedRequest.js"></script>
        <script src="asset/js/toggle_navbar.js"></script>
    </body>
    </html>