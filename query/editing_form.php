<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $conn->beginTransaction();

        $sql1 = "INSERT INTO tbl_audiovisual_depaide 
                (title, proj_desc, project_type, music_preference, deliverables, style_tone, delivery_method, project_deadline) 
        VALUES (:title, :proj_desc, :project_type, :music_preference, :deliverables, :style_tone, :delivery_method, :project_deadline)";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
            ':title' => $_POST['title'],
            ':proj_desc' => $_POST['proj_desc'],
            ':project_type' => $_POST['project_type'],
            ':music_preference' => $_POST['music_preference'],
            ':deliverables' => $_POST['deliverables'],
            ':style_tone' => $_POST['style_tone'],
            ':delivery_method' => $_POST['delivery_method'],
            ':project_deadline' => $_POST['project_deadline'],         
        ]);


        $table_id = $conn->lastInsertId();

        $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                 VALUES (:userId, :request_type_id, :request_type_table)";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
            ':userId' => $_SESSION['userId'],
            ':request_type_id' => $table_id,
            ':request_type_table' => 'audio_visual_editing'
        ]);
        $request_id = $conn->lastInsertId();
        $conn->commit();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title:'Request Submitted!',
                        text: 'Your Audio Visual Edit request has been submitted successfully.',
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