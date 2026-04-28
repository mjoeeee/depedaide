<?php       
include 'all_function.php';
include 'config.php';
include 'admin/query/view_audio.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Visual Editing Form</title>
    <!-- Add Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="asset/css/admin_view_audio.css">
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
        <h1>Audio Visual Editing Form</h1>
    </div>


    <!-- Form Container -->
    <div class="form-container">
        <!-- Project Title/Name -->
        <form method="post" action="">
        <div class="form-group">
        <input type="hidden" name="id" value="<?= htmlspecialchars(isset($result['id']) ? $result['id'] : '') ?>">
<input type="hidden" name="request_id" value="<?= htmlspecialchars(isset($result['request_id']) ? $result['request_id'] : '') ?>">

<label for="projectTitle">Project Title/Name</label>
<input type="text" id="projectTitle" name="projectTitle" value="<?= htmlspecialchars(isset($result['title']) ? $result['title'] : '') ?>">

<!-- Project Description -->
<div class="form-group">
    <label for="projectDescription">Project Description</label>
    <textarea id="projectDescription" rows="4" name="projectDescription"><?= htmlspecialchars(isset($result['proj_desc']) ? $result['proj_desc'] : '') ?></textarea>
</div>

        <script>
                document.addEventListener("DOMContentLoaded", function () {
                    function toggleOtherInput(selectId, otherInputId) {
                        const selectElement = document.getElementById(selectId);
                        const otherInput = document.getElementById(otherInputId);

                        selectElement.addEventListener("change", function () {
                            if (selectElement.value === "Other") {
                                otherInput.style.display = "block";
                            } else {
                                otherInput.style.display = "none";
                            }
                        });

                        // Check on load if "Other" was preselected
                        if (selectElement.value === "Other") {
                            otherInput.style.display = "block";
                        } else {
                            otherInput.style.display = "none";
                        }
                    }

                    toggleOtherInput("projectType", "otherProjectType");
                    toggleOtherInput("deliverables", "otherDeliverables");
                    toggleOtherInput("projectStyle", "otherProjectStyle");
                    toggleOtherInput("deliveryMethod", "otherDeliveryMethod");
                });
        </script>
        <!-- Type of Project and Music Preferences -->
<div class="form-row">
    <div class="form-group">
        <?php 
            $projectTypes = ["Corporate Video", "Event Video", "Promotional Video", "Tutorial/Training Video", "Documentary", "Tarpaulin"];
            $isOther = !in_array($result['project_type'], $projectTypes);
        ?>
        <label for="projectType">Type of Project</label>
        <select id="projectType" name="projectType" onchange="toggleMusicPreferences()">
            <option value="">Select Project</option>
            <option value="Corporate Video" <?php if ($result['project_type'] == "Corporate Video") echo "selected"; ?>>Corporate Video</option>
            <option value="Event Video" <?php if ($result['project_type'] == "Event Video") echo "selected"; ?>>Event Video</option>
            <option value="Promotional Video" <?php if ($result['project_type'] == "Promotional Video") echo "selected"; ?>>Promotional Video</option>
            <option value="Tutorial/Training Video" <?php if ($result['project_type'] == "Tutorial/Training Video") echo "selected"; ?>>Tutorial/Training Video</option>
            <option value="Documentary" <?php if ($result['project_type'] == "Documentary") echo "selected"; ?>>Documentary</option>
            <option value="Tarpaulin" <?php if ($result['project_type'] == "Tarpaulin") echo "selected"; ?>>Tarpaulin</option>
            <option value="Other" <?= $isOther ? "selected" : ""; ?>>Other</option>
        </select>
        <input type="text" id="otherProjectType" name="otherProjectType" class="form-control" 
            style="display: <?= $isOther ? "block" : "none"; ?>;" 
            value="<?= $isOther ? htmlspecialchars($result['project_type']) : ''; ?>">
    </div>

    <div class="form-group" id="musicPreferencesContainer">
        <label for="musicPreferences">Music Preferences</label>
        <select id="musicPreferences" name="musicPreferences">
            <option>Select Music Preference</option>
            <option value="Background Music" <?php if ($result['music_preference'] == "Background Music") echo "selected"; ?>>Background Music</option>
            <option value="No Music" <?php if ($result['music_preference'] == "No Music") echo "selected"; ?>>No Music</option>
            <option value="Music Provided by Client" <?php if ($result['music_preference'] == "Music Provided by Client") echo "selected"; ?>>Music Provided by Client</option>
        </select>
    </div>

    <script>
        function toggleMusicPreferences() {
            var projectType = document.getElementById("projectType").value;
            var musicPreferencesDiv = document.getElementById("musicPreferencesContainer");
            var deliverablesDiv = document.getElementById("deliverables");
            var styleToneDiv = document.getElementById("style_tone");

            // Hide music preferences, deliverables, and style & tone if "Tarpaulin" is selected
            if (projectType === "Tarpaulin") {
                musicPreferencesDiv.style.display = "none";
                deliverablesDiv.style.display = "none";
                styleToneDiv.style.display = "none";
            } else {
                musicPreferencesDiv.style.display = "block";
                deliverablesDiv.style.display = "block";
                styleToneDiv.style.display = "block";
            }
        }

        // Run on page load to ensure correct state
        document.addEventListener("DOMContentLoaded", function() {
            toggleMusicPreferences();
        });
    </script>
</div>

<!-- Expected Deliverables and Project Style & Tone -->
<div class="form-row">
<div class="form-group">
    <?php 
        $projectTypes = ["Edited Video", "Audio-Only", "Image-Only", "Raw Footage/Audio", "Clips"];
        $isOther = !in_array($result['deliverables'], $projectTypes);
    ?>
    <label for="deliverables">Expected Deliverables</label>
    <select id="deliverables" name="deliverables" class="form-control">
        <option value="">Select Deliverables</option>
        <?php foreach ($projectTypes as $type) { ?>
            <option value="<?= htmlspecialchars($type); ?>" <?= ($result['deliverables'] == $type) ? "selected" : ""; ?>>
                <?= htmlspecialchars($type); ?>
            </option>
        <?php } ?>
        <option value="Other" <?= $isOther ? "selected" : ""; ?>>Other</option>
    </select>

    <input type="text" id="otherDeliverables" name="deliverables" class="form-control" 
        style="display: <?= $isOther ? "block" : "none"; ?>;" 
        value="<?= $isOther ? htmlspecialchars($result['deliverables']) : ''; ?>">
</div>

<script>
    document.getElementById("deliverables").addEventListener("change", function() {
        var otherInput = document.getElementById("otherDeliverables");

        if (this.value === "Other") {
            otherInput.style.display = "block";
            otherInput.setAttribute("name", "deliverables"); // Use input name
            this.removeAttribute("name"); // Remove select name
        } else {
            otherInput.style.display = "none";
            otherInput.removeAttribute("name"); // Remove input name
            this.setAttribute("name", "deliverables"); // Restore select name
            otherInput.value = ""; // Clear input value when hidden
        }
    });
</script>

    <div class="form-group" id="style_tone">
        <?php 
            $projectTypes = ["Cinematic", "Documentary-Style", "Corporate/Professional", "Casual/Informal", "High-Energy", "Artistic/Experimental"];
            $isOther = !in_array($result['style_tone'], $projectTypes);
        ?>
        <label for="projectStyle">Project Style & Tone</label>
        <select id="projectStyle" name="projectStyle">
            <option value="">Select Style</option>
            <option value="Cinematic" <?php if ($result['style_tone'] == "Cinematic") echo "selected"; ?>>Cinematic</option>
            <option value="Documentary-Style" <?php if ($result['style_tone'] == "Documentary-Style") echo "selected"; ?>>Documentary-Style</option>
            <option value="Corporate/Professional" <?php if ($result['style_tone'] == "Corporate/Professional") echo "selected"; ?>>Corporate/Professional</option>
            <option value="Casual/Informal" <?php if ($result['style_tone'] == "Casual/Informal") echo "selected"; ?>>Casual/Informal</option>
            <option value="High-Energy" <?php if ($result['style_tone'] == "High-Energy") echo "selected"; ?>>High-Energy</option>
            <option value="Artistic/Experimental" <?php if ($result['style_tone'] == "Artistic/Experimental") echo "selected"; ?>>Artistic/Experimental</option>
            <option value="Other" <?= $isOther ? "selected" : ""; ?>>Other</option>
        </select>
        <input type="text" id="otherProjectStyle" name="otherProjectStyle" class="form-control" 
            style="display: <?= $isOther ? "block" : "none"; ?>;" 
            value="<?= $isOther ? htmlspecialchars($result['style_tone']) : ''; ?>">
    </div>
</div>

        <!-- Preferred Delivery Method and Project Deadline -->
        <div class="form-row">
            <div class="form-group">
                <?php 
                    $projectTypes = ["Google Drive", "Dropbox", "WeTransfer", "FTP Upload"];
                    $isOther = !in_array($result['delivery_method'], $projectTypes);
                ?>
                <label for="deliveryMethod">Preferred Delivery Method</label>
                <select id="deliveryMethod" name="deliveryMethod">
                    <option>Select Delivery</option>
                    <option value="Google Drive" <?php if ($result['delivery_method'] == "Google Drive") echo "selected"; ?>>Google Drive</option>
                    <option value="Dropbox" <?php if ($result['delivery_method'] == "Dropbox") echo "selected"; ?>>Dropbox</option>
                    <option value="WeTransfer" <?php if ($result['delivery_method'] == "WeTransfer") echo "selected"; ?>>WeTransfer</option>
                    <option value="FTP Upload" <?php if ($result['delivery_method'] == "FTP Upload") echo "selected"; ?>>FTP Upload</option>
                    <option value="Other" <?= $isOther ? "selected" : ""; ?>>Other</option>
                </select>
                <input type="text" id="otherDeliveryMethod" name="otherDeliveryMethod" class="form-control" 
                    style="display: <?= $isOther ? "block" : "none"; ?>;" 
                    value="<?= $isOther ? htmlspecialchars($result['delivery_method']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="projectDeadline">Project Deadline</label>
                <input type="datetime-local" name="projectDeadline" id="projectDeadline" value="<?= htmlspecialchars(isset($result['project_deadline']) ? $result['project_deadline'] : '') ?>">

            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Details</button>
            <a href="status" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </div>
            </form>
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