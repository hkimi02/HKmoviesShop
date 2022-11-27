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
        if($_SESSION['isAdmin']==1){
        header('location:../admin/index.php?msg=welcome boss&class=success');
        }else if($_SESSION['isEmploye']==1){
            header('location:../profile_employe/index.php?msg=welcome employe&class=success');
        }
        else{
            header('location:../profile_user/index.php?msg=welcome user&class=success');
        }
    }
        else{
            header('location:../layout.phtml?msg=verify you email and password&class=danger');
        }
    }
?>