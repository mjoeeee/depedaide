<?php
if (isset($_SESSION['userId']) && ($_SESSION['role']) != "System Admin") {
    header("Location: ../logout");
    exit();
}
?>