<?php
try {
    // SQL query to count total requests from multiple tables joined with tbl_request_depaide
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
            tbl_audiovisual_depaide a ON r.request_type_id = a.id AND r.userId = :userId
        LEFT JOIN 
            tbl_document_depaide d ON r.request_type_id = d.id AND r.userId = :userId
        LEFT JOIN 
            tbl_inspection_depaide i ON r.request_type_id = i.id AND r.userId = :userId
        LEFT JOIN 
            tbl_passreset_depaide p ON r.request_type_id = p.id AND r.userId = :userId
        LEFT JOIN 
            tbl_softdev_depaide s ON r.request_type_id = s.id AND r.userId = :userId
        LEFT JOIN 
            tbl_ictmrf_depaide ictmrf ON r.request_type_id = ictmrf.id AND r.userId = :userId
        LEFT JOIN 
            tbl_printingid_depaide print ON r.request_type_id = print.id AND r.userId = :userId
        LEFT JOIN 
            tbl_depedemail_depaide em ON r.request_type_id = em.id AND r.userId = :userId
        WHERE 
            r.userId = :userId
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
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