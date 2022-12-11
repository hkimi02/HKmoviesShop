<?php
require_once '../db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;

include "../send.php";

if (isset($_POST['submit'])) {
    extract($_POST);
    //check username length
    if (strlen($username) < 4) {
        header('location:index.php?msg=username length should be more than 4&class=danger');
        exit;
    }
    //check unique username
    $req = $db->prepare('SELECT username FROM users WHERE username=:username');
    $req->execute(['username' => $username]);
    if ($req->rowCount()) {
        header('location:index.php?msg=username already exists&class=danger');
        exit;
    }
    //check unique email
    $req = $db->prepare('SELECT email FROM users WHERE email=:email');
    $req->execute(['email' => $email]);
    if ($req->rowCount()) {
        header('location:index.php?msg=email already exists&class=danger');
        exit;
    }
    //confirm password
    if ($password == $password2) {
        $password = md5($password);
    } else {
        header("location:index.php?msg=confirm your password please !&class=danger");
        exit;
    }
    //avatar
    //check extantion
    $name_file = $_FILES['avatar']['name'];
    $type = pathinfo($name_file, PATHINFO_EXTENSION);
    $type_dispo = ['png', 'jpg', 'jpeg', 'gif'];
    if (!in_array($type, $type_dispo)) {
        header("location:index.php?msg=extention invalid&class=danger");
        exit;
    }
    //check size 
    /*$size=$_FILES['avatar']['size'];
        if($size>){
            header("location:index.php?msg=image size too large&class=danger");
            exit;
        }*/
    //move file to the project storage and generate the avatar path 
    $name_file = md5(mt_rand()) . '.' . $type;
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../storage/' . $name_file)) {
        header("location:index.php?msg=image not uploaded&class=danger");
        exit;
    }
    $avatar = '../storage/' . $name_file;
    $token = md5($username);
    $date = date('y/m/d');
    $sql = $db->prepare("INSERT INTO `users`( `username`, `email`, `password`,avatar ,`isAdmin`, `isEmploye`, `createdate`,`token_verified`, `verified`)
    VALUES (:us,:em,:pass,:avatar,:isadmin,:isempl,:create,:token,:verif)");
    $sql->execute([
        'us' => $username,
        'em' => $email,
        'pass' => $password,
        'avatar'=>$avatar,
        'isadmin' => 0,
        'isempl' => 0,
        'create' => $date,
        'verif' => 0,
        'token' => $token
    ]);
    $link = "<a href='" . $_SERVER['HTTP_HOST'] . "/" . explode('/', $_SERVER['PHP_SELF'])[1] . "/verify/index.php?token=" . $token . "&email=" . $email . "'>cliquer ici pour verifier</a>";
    sendmail('HKmoviesShop', $email, 'Lien de verifiaction', 'lien' . $link . '');
}

show:
include './home.phtml';
