<?php
try {

    $sql = "
        SELECT 
            COUNT(DISTINCT ictmrf.id) AS ictmrf_count,
            COUNT(DISTINCT a.id) AS audiovisual_count,
            COUNT(DISTINCT d.id) AS document_count,
            COUNT(DISTINCT i.id) AS inspection_count,
            COUNT(DISTINCT p.id) AS passreset_count,
            COUNT(DISTINCT s.id) AS softdev_count,
            COUNT(DISTINCT print.id) AS print_count,
            COUNT(DISTINCT em.id) AS em_count
        FROM 
            tbl_request_depaide r
        LEFT JOIN 
            tbl_audiovisual_depaide a ON r.request_type_id = a.id
        LEFT JOIN 
            tbl_document_depaide d ON r.request_type_id = d.id
        LEFT JOIN 
            tbl_inspection_depaide i ON r.request_type_id = i.id
        LEFT JOIN 
            tbl_passreset_depaide p ON r.request_type_id = p.id
        LEFT JOIN 
            tbl_softdev_depaide s ON r.request_type_id = s.id
        LEFT JOIN 
            tbl_ictmrf_depaide ictmrf ON r.request_type_id = ictmrf.id
        LEFT JOIN 
            tbl_printingid_depaide print ON r.request_type_id = print.id
        LEFT JOIN 
            tbl_depedemail_depaide em ON r.request_type_id = em.id
    ";

    // Assuming $userId is set somewhere earlier in the code
    $stmt = $conn->prepare($sql);
    // If $userId is required by the query, use it here
    //$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // Uncomment if you need to bind userId
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
 $audiovisualCount = isset($row['audiovisual_count']) ? $row['audiovisual_count'] : 0;
$ictmrf_count = isset($row['ictmrf_count']) ? $row['ictmrf_count'] : 0;
$documentCount = isset($row['document_count']) ? $row['document_count'] : 0;
$inspectionCount = isset($row['inspection_count']) ? $row['inspection_count'] : 0;
$passresetCount = isset($row['passreset_count']) ? $row['passreset_count'] : 0;
$softdevCount = isset($row['softdev_count']) ? $row['softdev_count'] : 0;
$print_count = isset($row['print_count']) ? $row['print_count'] : 0;
$em_count = isset($row['em_count']) ? $row['em_count'] : 0;

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<?php
// Define request types
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

// Initialize counts for each request type and status
$request_counts = [];

foreach ($request_types as $type) {
    $request_counts[$type] = [
        'Pending' => 0,
        'In Progress' => 0,
        'Completed' => 0,
        'Rejected' => 0
    ];
}

// Fetch counts for all request types in one query
$sql = "SELECT request_type_table, stat, COUNT(*) as count 
        FROM tbl_request_depaide 
        WHERE request_type_table IN ('" . implode("','", $request_types) . "') 
        GROUP BY request_type_table, stat";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store results in the associative array
foreach ($results as $row) {
    $request_counts[$row['request_type_table']][$row['stat']] = $row['count'];
}


?>