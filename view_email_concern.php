<?php       
include 'all_function.php';
include 'config.php';
include 'query/view_email_concern.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Concern Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="asset/css/admin_view_software_request.css">

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
        <h1>Email Concern Form</h1>
    </div>
<!-- Form Container -->
<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="input-group">
                    <label for="reason">Email</label>
                    <input type="text" id="reason" name="reason" value="<?= htmlspecialchars($result['email'] ? $result['email'] : '') ?>" readonly>
                </div>  
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'] ? $result['id'] : '') ?>">
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($result['request_id'] ? $result['request_id'] : '') ?>">
                    <div class="input-group">
                        <label for="reason">Reason</label>
                        <textarea type="text" id="reason" name="reason"><?= htmlspecialchars($result['reason'] ? $result['reason'] : '') ?>
                        </textarea>    
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="row">

                <div class="input-group">
                <label for="reason">Screenshot</label>
                <br>
    <?php if (!empty($result['attachment'])): ?>
        <?php
        $fileExtension = pathinfo($result['attachment'], PATHINFO_EXTENSION);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $documentIcons = [
            'pdf' => 'fa-file-pdf', 
            'doc' => 'fa-file-word', 
            'docx' => 'fa-file-word', 
            'xls' => 'fa-file-excel', 
            'xlsx' => 'fa-file-excel', 
            'ppt' => 'fa-file-powerpoint', 
            'pptx' => 'fa-file-powerpoint', 
            'txt' => 'fa-file-alt',
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive'
        ];
        ?>

        <?php if (in_array(strtolower($fileExtension), $imageExtensions)): ?>
            <img id="existingPreview" src="<?= htmlspecialchars($result['attachment']) ?>?t=<?= time() ?>" 
     alt="Attachment Preview" 
     style="max-width: 30%; height: auto; margin-top: 30px;">

        <?php else: ?>
            <p>
            <i class="fas <?= isset($documentIcons[$fileExtension]) ? $documentIcons[$fileExtension] : 'fa-file' ?>">

                   style="font-size: 24px; color: #007bff; margin-right: 5px; max-width: 30%; margin-top: 10px;"></i>
                <a href="<?= htmlspecialchars($result['attachment']) ?>" download>
                    <?= htmlspecialchars(basename($result['attachment'])) ?>
                </a>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <input type="file" name="attachment" id="fileInput">
    <div id="filePreview" style="margin-top: 10px;"></div>
</div>

<script>
document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('filePreview');
    previewContainer.innerHTML = '';

    if (file) {
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const documentIcons = {
            'pdf': 'fa-file-pdf',
            'doc': 'fa-file-word',
            'docx': 'fa-file-word',
            'xls': 'fa-file-excel',
            'xlsx': 'fa-file-excel',
            'ppt': 'fa-file-powerpoint',
            'pptx': 'fa-file-powerpoint',
            'txt': 'fa-file-alt',
            'zip': 'fa-file-archive',
            'rar': 'fa-file-archive'
        };

        if (imageExtensions.includes(fileExtension)) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 30%; height: auto;">`;
            };
            reader.readAsDataURL(file);
        } else {
            const iconClass = documentIcons[fileExtension] || 'fa-file';
            previewContainer.innerHTML = `<p>
                <i class="fas ${iconClass}" style="font-size: 24px; color: #007bff; margin-right: 5px;"></i>
                ${file.name}
            </p>`;
        }
    }
});
</script>

            </div>
        </div>

       

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Update Details</button>
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