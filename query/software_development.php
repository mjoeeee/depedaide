
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->beginTransaction();

        $sql1 = "INSERT INTO tbl_softdev_depaide 
                (proj_name, brief_desc, prime_obj, features, spec, proj_deadline, add_info) 
        VALUES (:proj_name, :brief_desc, :prime_obj, :features, :spec, :proj_deadline, :add_info)";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
                        ':proj_name' => $_POST['proj_name'],
                        ':brief_desc' => $_POST['brief_desc'],
                        ':prime_obj' => $_POST['prime_obj'],
                        ':features' => $_POST['features'],
                        ':spec' => $_POST['spec'],
                        ':proj_deadline' => $_POST['proj_deadline'],
                        ':add_info' => $_POST['add_info'],
                        ]);

        $table_id = $conn->lastInsertId();

        if (!empty($_FILES['attachment']['name'])) {
            $upload_dir = "asset/uploads/soft_dev/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_tmp = $_FILES['attachment']['tmp_name'];
            $file_ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            $new_filename = $table_id . '.' . $file_ext;
            $file_path = $upload_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $file_path)) {

                $sql_update = "UPDATE tbl_softdev_depaide SET attachment = :attachment WHERE id = :softdev_id";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute([
                    ':attachment' => $file_path,
                    ':softdev_id' => $table_id
                ]);
            } else {
                throw new Exception("File upload failed.");
            }
        }

        $sql2 = "INSERT INTO tbl_request_depaide (userId, request_type_id, request_type_table) 
                 VALUES (:userId, :request_type_id, :request_type_table)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
                            ':userId' => $_SESSION['userId'],
                            ':request_type_id' => $table_id,
                            ':request_type_table' => 'software_development'
                        ]);
        $request_id = $conn->lastInsertId();
        $conn->commit();
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title:'Request Submitted!',
                        text: 'Your Software Development request has been submitted successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'status?request_id=".$request_id."';
                    });
                });
              </script>";

    } catch (Exception $e) {
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