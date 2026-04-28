<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $conn->beginTransaction();

        $sql1 = "INSERT INTO tbl_ictmrf_depaide 
                (date_current, time_current, req_name, req_designation, req_DO, DOPE, brand, prop_no, serial_no, date_last_repair, defects) 
                VALUES ( :date_current, :time_current, :req_name, :req_designation, :req_DO, :DOPE, :brand, :prop_no, :serial_no, :date_last_repair, :defects)";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
            ':date_current' => $_POST['date'],
            ':time_current' => $_POST['time'],
            ':req_name' => $_POST['name'],
            ':req_designation' => $_POST['designation'],
            ':req_DO' => $_POST['divisionOffice'],
            ':DOPE' => $_POST['propertyDescription'],
            ':brand' => $_POST['brand'],
            ':prop_no' => $_POST['propertyNumber'],
            ':serial_no' => $_POST['serialNumber'],
            ':date_last_repair' => $_POST['lastRepairDate'],
            ':defects' => $_POST['defects']
        ]);


        $maintenance_id = $conn->lastInsertId();

        $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                 VALUES (:userId, :request_type_id, :request_type_table)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
            ':userId' => $_SESSION['userId'],
            ':request_type_id' => $maintenance_id,
            ':request_type_table' => 'ict_maintenance'
        ]);
        $request_id = $conn->lastInsertId();
        $conn->commit();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Request Submitted!',
                        text: 'Your ICT Maintenance request has been recorded successfully.',
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