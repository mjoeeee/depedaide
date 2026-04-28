<?php       
include 'all_function.php';
include 'config.php';
include 'query/view_documentation.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="asset/css/admin_view_ict_inspection.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="image/logo (1).png" alt="Logo"> <!-- Replace with your logo path -->
        </a>
    </nav>

    <!-- Header Card with Breadcrumb -->
    <div class="header-card">
            <div class="breadcrumb">
                <span class="separator"></span>
                <a href="status">Go back</a>
                <span class="separator">/</span>
                <span>Request Form</span>
            </div>
        <h1>Documentation Form</h1>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form action="" method="POST">


                    <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'] ? $result['id'] : '') ?>">
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($result['request_id'] ? $result['request_id'] : '') ?>">


        <!-- Acquisition Cost and Acquisition Date -->
        <div class="form-row">
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($result['title'] ?$result['title'] : '') ?>" placeholder="Enter Acquisition Cost">
            </div>
            <div class="form-group">
                <label for="event_location">Location of Event</label>
                <input type="text" id="event_location" name="event_location" value="<?= htmlspecialchars($result['event_location'] ? $result['event_location'] : '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input id="event_date" type="date" rows="6" name="event_date" placeholder="Enter Event Date" value="<?= htmlspecialchars($result['event_date'] ? $result['event_date'] : '')?>">
            </div>
            <div class="form-group">
            <label for="event_date">Start Time</label>
            <input id="start_time"  type="time" rows="6" name="start_time" placeholder="Enter Start Time" value="<?= htmlspecialchars($result['start_time'] ? $result['start_time'] : '')?>">
            </div>
            <div class="form-group">
            <label for="event_date">End Time</label>
            <input id="end_time"  type="time" rows="6" name="end_time" placeholder="Enter End Time" value="<?= htmlspecialchars($result['end_time'] ? $result['end_time'] : '')?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="details">Details</label>
                <textarea type="text" id="details" name="details" placeholder="Documentation Details"><?= htmlspecialchars($result['details'] ? $result['details'] : '') ?></textarea>
            </div>

        </div>
        <h3 style="color: #007bff; font-weight: bold; display: flex; align-items: center;">
 
        <!-- Buttons Section -->
        <div class="d-flex justify-content-end gap-2 mt-3 w-100">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Details</button>
            <a href="status" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
    </div>
    </form>
    </div>
    <?php if (isset($_GET['update']) && $_GET['update'] == "success"): ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Updated Successfully!",
            text: "The record has been updated.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == "invalid_request"): ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Update Failed!",
            text: "Something went wrong. Please try again.",
            showConfirmButton: true
        });
    </script>
<?php endif; ?>
</body>
</html>