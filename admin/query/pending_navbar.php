<?php


$request_types = [
    'ict_maintenance',
    'software_development',
    'ict_equipment_inspection',
    'documentation',
    'audio_visual_editing',
    'deped_email_request',
    'password_reset',
    'id_card_printing'
];

$pending_counts = [];


$sql = "SELECT request_type_table, COUNT(*) as count FROM tbl_request_depaide WHERE stat = 'Pending' GROUP BY request_type_table";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($request_types as $type) {
    $pending_counts[$type] = 0; 
}

foreach ($results as $row) {
    $pending_counts[$row['request_type_table']] = $row['count'];
}

?>