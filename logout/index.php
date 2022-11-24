<?php 
    session_start();
    session_destroy();
    unset($_SESSION['username']);
    header("location:../layout.phtml");
?>