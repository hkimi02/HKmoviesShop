<?php
require_once '../db_connect.php';
session_start();
$avatar = '';
$password = '';
if (array_key_exists('edit_info', $_GET)) {
    $id_user = $_GET['edit_info'];
    $req = $db->prepare('SELECT * FROM users WHERE iduser=:iduser');
    $req->execute(['iduser' => $id_user]);
    $user = $req->fetch();
}
if (isset($_POST['update'])) {
    extract($_POST);

    if (!empty($_FILES['avatar']['name'])) {
        //avatar
        //check extantion
        $name_file = $_FILES['avatar']['name'];
        $type = pathinfo($name_file, PATHINFO_EXTENSION);
        $type_dispo = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($type, $type_dispo)) {
            header("location:index.php?msg=extention invalid&type=danger");
            exit;
        }
        //check size 
        /*$size=$_FILES['avatar']['size'];
        if($size>){
            header("location:index.php?msg=image size too large&type=danger");
            exit;
        }*/
        //move file to the project storage and generate the avatar path 
        $name_file = md5(mt_rand()) . '.' . $type;
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../storage/' . $name_file)) {
            header("location:index.php?msg=image not uploaded&type=danger");
            exit;
        }
        $avatar = '../storage/' . $name_file;
    }
    else{
        $avatar=$old_avatar;
    }
    if(empty($password)){
        $password=$old_password;
    }else{
        $password=md5($password);
    }
    $req=$db->prepare('UPDATE users set username=:username,email=:email,password=:password,avatar=:avatar WHERE iduser=:iduser');
    $req->execute([
        'username'=>$username,
        'email'=>$email,
        'password'=>$password,
        'avatar'=>$avatar,
        'iduser'=>$id,
    ]);
    $_SESSION['username']=$username;
    $_SESSION['email']=$email;
    $_SESSION['password']=$password;
    $_SESSION['avatar']=$avatar;
    if($req){
    if($_SESSION['isAdmin']==1){
        header('location:../admin/index.php?msg=info updated succesfully');
    }else if($_SESSION['isEmploye']==1){
        header('location:../profile_employe/index.php?msg=info updated succesfully');
    }else{
        header('location:../profile_user/index.php?msg=info updated succesfully');
    }
}
}
include 'home.phtml';
