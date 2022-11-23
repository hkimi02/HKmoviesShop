<?php 
        require_once '../db_connect.php';
    if(isset($_POST['login'])){
        extract($_POST);
        $req=$db->prepare('SELECT * FROM users WHERE email=:email AND password=:password');
        $req->execute([
            'email'=>$eamil,
            'password'=>md5($password),
        ]);
        $res=$req->fetch();
        if($res){
            session_start();
        $_SESSION['iduser']=$res['iduser'];
        $_SESSION['username']=$res['username'];
        $_SESSION['email']=$res['email'];
        $_SESSION['isAdmin']=$res['isAdmin'];
        $_SESSION['isEmploye']=$res['isEmploye'];
        $_SESSION['createdate']=$res['createdate'];
        $_SESSION['verified']=$res['verified'];
        header('location:../admin/index.php?msg=welcome boss');
        }
    }
?>