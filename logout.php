<?php
    if(($_SESSION['role']) == "System Admin"){
        session_start();
        session_unset();
        session_destroy();
        header("Location: login");
        exit();
    }else{

        session_start();
        session_unset();
        session_destroy();
        header("Location: login"); 
    exit();
    }
?>
