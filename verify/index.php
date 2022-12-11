<?php 
require_once '../db_connect.php';
  $resultat=0;
  if(array_key_exists('email',$_GET) && array_key_exists('token',$_GET)){
    $email=$_GET['email'];
    $token=$_GET['token'];
    $sql=$db->prepare("SELECT * from users where email=:email and token_verified=:token");
    $sql->execute(['token'=>$token,'email'=>$email]);
    $user=$sql->fetch();
    try{
      if($user){
        if($user['verified']==1){
            $resultat=1;
  include "./verify.phtml";
  exit;
        }else if($user['verified']==0){
            $sql=$db->prepare("UPDATE users SET token_verified=null,verified=1 where iduser=:id");
            $sql->execute(['id'=>$user['iduser']]);
            $resultat=2;
  include "./verify.phtml";
  exit;
        }
      }else{
        $resultat=3;
  include "./verify.phtml";
  exit;
      }
    }catch(Exception $e){
        $resultat=4;
    }

  }
