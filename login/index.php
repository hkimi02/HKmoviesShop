<?php 
        require_once '../db_connect.php';
        session_start();
    if(isset($_POST['login'])){
        extract($_POST);
        $req=$db->prepare('SELECT * FROM users WHERE email=:email AND password=:password');
        $req->execute([
            'email'=>$email,
            'password'=>md5($password),
        ]);
        $res=$req->fetch();
        var_dump($res);
        if($res){
        $_SESSION['iduser']=$res['iduser'];
        $_SESSION['username']=$res['username'];
        $_SESSION['email']=$res['email'];
        $_SESSION['avatar']=$res['avatar'];
        $_SESSION['isAdmin']=$res['isAdmin'];
        $_SESSION['isEmploye']=$res['isEmploye'];
        $_SESSION['createdate']=$res['createdate'];
        $_SESSION['verified']=$res['verified'];
        header('location:../admin/index.php?msg=welcome boss');
        }
        else{
            header('location:../layout.phtml?msg=verify you email and password');
        }
    }
?>