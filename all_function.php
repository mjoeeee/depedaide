<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: logout");
    exit();
}

if (!isset($_SESSION['userId']) && ($_SESSION['role']) == "System Admin") {
    header("Location: ../logout");
    exit();
}
?>