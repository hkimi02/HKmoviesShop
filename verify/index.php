<?php 
require_once '../db_connect.php';
  $email=$_GET['email'];
  $token=$_GET['token'];
  $resultat=0;
  if(!empty($email) && !empty($token)){
    $sql=$db->prepare("SELECT * from users where token_verified=:token and email=:email");
    $sql->execute(['token'=>$token,'email'=>$email]);
    $user=$sql->fetch(PDO::FETCH_ASSOC);
    try{
      if($user){
        if($user['verified']==1){
            $resultat=1;
        }else{
            $sql=$db->prepare("Update users SET token_verified=null,verified=1 where iduser=:id");
            $sql->execute(['id'=>$user['iduser']]);
            $resultat=2;
        }
      }else{
        $resultat=3;
      }
    }catch(Exception $e){
        $resultat=4;
    }

  }
  include "./verify.phtml";
