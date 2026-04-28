
<?php

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function hassed_passphrase($password) {
    $saltkey = 'qW3Mr4mL3Az51fOsvKV7W7Li6vBfpPtj';
    $salt_a = '5ae7U467wqH';
    $salt_b = '$G$' . substr(sha1($password . $saltkey), -4) . 'J.';
    $salt_c = '.' . substr(sha1($password . $salt_b . "xsi3"), -8) . substr(sha1($salt_a . $salt_b), -3);

    if ($password != "") {
        $hassed_password = $salt_b . md5($saltkey . $password) . $salt_c;
        return $hassed_password;
    } else {
        return "";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashed_password = hassed_passphrase($password);

            if ($user['password'] === $hashed_password) {
                session_start();
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['middlename'] = $user['middlename'];
                $_SESSION['extname'] = $user['extname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['job_title'] = $user['job_title'];
                $_SESSION['hrId'] = $user['hrId'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['department_id'] = $user['department_id'];

                    // Fetch additional info from tbl_emp_official_info and join with tbl_emp_personal_info
                    $stmt2 = $conn->prepare("
                        SELECT 
                            eoi.prefix_name, eoi.employee_id, 
                            epi.blood_type, epi.prc_no, epi.sss, epi.gsis, epi.pag_ibig, epi.philhealth, epi.tin ,epi.dob 
                        FROM tbl_emp_official_info eoi
                        JOIN tbl_emp_personal_info epi ON eoi.id = epi.hrid
                        WHERE eoi.id = :userId
                    ");

                    $stmt2->bindParam(':userId', $user['userId']);
                    $stmt2->execute();

                    $emp_info = $stmt2->fetch(PDO::FETCH_ASSOC);

                    if ($emp_info) {
                        $_SESSION['prefix_name'] = $emp_info['prefix_name'];
                        $_SESSION['employee_id'] = $emp_info['employee_id'];
                        $_SESSION['blood_type'] = $emp_info['blood_type'];
                        $_SESSION['prc_no'] = $emp_info['prc_no'];
                        $_SESSION['sss'] = $emp_info['sss'];
                        $_SESSION['gsis'] = $emp_info['gsis'];
                        $_SESSION['pag_ibig'] = $emp_info['pag_ibig'];
                        $_SESSION['philhealth'] = $emp_info['philhealth'];
                        $_SESSION['tin'] = $emp_info['tin'];
                        $_SESSION['dob'] = $emp_info['dob'];
                    }

                if ($user['role'] === "System Admin") {
                    header("Location: admin/dashboard");
                } else {
                    header("Location: dashboard");
                }
                exit();   
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>