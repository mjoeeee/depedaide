<?php
try {
    $request_id = isset($_GET['request_id']) ? $_GET['request_id'] : '';

    $stmt = $conn->prepare("SELECT *
                            FROM tbl_printingid_depaide d
                            JOIN tbl_request_depaide r ON d.id = r.request_type_id 
                            JOIN tbl_user u ON r.userId = u.userId
                            JOIN tbl_emp_official_info emp ON r.userId = emp.id
                            WHERE r.request_type_table = 'id_card_printing'
                            AND r.request_id = :request_id
                        ");

    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>