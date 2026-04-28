<?php
try {
    // Get and sanitize request_id
    $request_id = filter_input(INPUT_GET, 'request_id', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query using a placeholder
    $stmt = $conn->prepare("SELECT * 
                            FROM tbl_audiovisual_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            WHERE r.request_type_table = 'audio_visual_editing' AND r.request_id = ?
                            ORDER BY r.created_at DESC
                          ");
    $stmt->execute([$request_id]);

    // Fetch single row
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {


        $request_id = filter_input(INPUT_POST, 'request_id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $projectTitle = filter_input(INPUT_POST, 'projectTitle', FILTER_SANITIZE_STRING);
        $projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_STRING);

        $projectType = filter_input(INPUT_POST, 'projectType', FILTER_SANITIZE_STRING);
        $deliverables = filter_input(INPUT_POST, 'deliverables', FILTER_SANITIZE_STRING);
        $projectStyle = filter_input(INPUT_POST, 'projectStyle', FILTER_SANITIZE_STRING);
        $deliveryMethod = filter_input(INPUT_POST, 'deliveryMethod', FILTER_SANITIZE_STRING);
        $projectDeadline = filter_input(INPUT_POST, 'projectDeadline', FILTER_SANITIZE_STRING);
        $musicPreferences = filter_input(INPUT_POST, 'musicPreferences', FILTER_SANITIZE_STRING);

        // Handle "Other" fields
        $projectType = ($projectType === 'Other') ? filter_input(INPUT_POST, 'otherProjectType', FILTER_SANITIZE_STRING) : $projectType;
        $deliverables = ($deliverables === 'Other') ? filter_input(INPUT_POST, 'otherDeliverables', FILTER_SANITIZE_STRING) : $deliverables;
        $projectStyle = ($projectStyle === 'Other') ? filter_input(INPUT_POST, 'otherProjectStyle', FILTER_SANITIZE_STRING) : $projectStyle;
        $deliveryMethod = ($deliveryMethod === 'Other') ? filter_input(INPUT_POST, 'otherDeliveryMethod', FILTER_SANITIZE_STRING) : $deliveryMethod;


        // Prepare the SQL query
        $sql = "UPDATE tbl_audiovisual_depaide SET 
                    title = :title, 
                    proj_desc = :proj_desc, 
                    project_type = :project_type, 
                    deliverables = :deliverables, 
                    style_tone = :style_tone, 
                    delivery_method = :delivery_method, 
                    music_preference = :music_preference, 
                    project_deadline = :project_deadline
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $projectTitle,
            ':proj_desc' => $projectDescription,
            ':project_type' => $projectType,
            ':deliverables' => $deliverables,
            ':style_tone' => $projectStyle,
            ':delivery_method' => $deliveryMethod,
            ':music_preference' => $musicPreferences,
            ':project_deadline' => $projectDeadline,
            ':id' => $id
        ]);

        // Redirect to ict_maintenance.php with success message
        header("Location: view_audio.php?update=success&request_id=$request_id");
        exit(); 
        
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}

?>