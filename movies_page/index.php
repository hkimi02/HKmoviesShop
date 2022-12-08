<?php 
    require_once '../db_connect.php';
    session_start();
    if(isset($_SESSION['username'])){
    include './home.phtml';
    }else{
        header('location:../index.php?msg=you have to log in to acces movies page&class=danger');
    }
?>