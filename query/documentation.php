<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $conn->beginTransaction();

        $sql1 = "INSERT INTO tbl_document_depaide 
                (title, event_location, event_date, start_time, end_time, details) 
        VALUES (:title, :event_location, :event_date, :start_time, :end_time, :details)";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
            ':title' => $_POST['title'],
            ':event_location' => $_POST['event_location'],
            ':event_date' => $_POST['event_date'],
            ':start_time' => $_POST['start_time'],
            ':end_time' => $_POST['end_time'],
            ':details' => $_POST['details']
        ]);


        $table_id = $conn->lastInsertId();

        $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                 VALUES (:userId, :request_type_id, :request_type_table)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
            ':userId' => $_SESSION['userId'],
            ':request_type_id' => $table_id,
            ':request_type_table' => 'documentation'
        ]);

        $request_id = $conn->lastInsertId();
        $conn->commit();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title:'Request Submitted!',
                        text: 'Your Documentation request has been submitted successfully.',
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