<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $conn->beginTransaction();

        $sql1 = "INSERT INTO tbl_inspection_depaide 
                (item, property_no, receipt_no, acquisition_cost, acquisition_date, complaints, scope_last_repair) 
        VALUES (:item, :property_no, :receipt_no, :acquisition_cost, :acquisition_date, :complaints, :scope_last_repair)";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
            ':item' => $_POST['item'],
            ':property_no' => $_POST['property_no'],
            ':receipt_no' => $_POST['receipt_no'],
            ':acquisition_cost' => $_POST['acquisition_cost'],
            ':acquisition_date' => $_POST['acquisition_date'],
            ':complaints' => $_POST['complaints'],
            ':scope_last_repair' => $_POST['scope_last_repair']
        ]); 


        $table_id = $conn->lastInsertId();

        $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                 VALUES (:userId, :request_type_id, :request_type_table)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
            ':userId' => $_SESSION['userId'],
            ':request_type_id' => $table_id,
            ':request_type_table' => 'ict_equipment_inspection'
        ]);
        $request_id = $conn->lastInsertId();
        $conn->commit();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title:'Request Submitted!',
                        text: 'Your ICT Equipment Inspection request has been submitted successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'status?request_id=".$request_id."';
                    });
                });
              </script>";

    } catch (PDOException $e) {
        $conn->rollBack(); 
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '" . addslashes($e->getMessage()) . "',
                        confirmButtonText: 'OK'
                    });
                });
              </script>";
    }
}
?>