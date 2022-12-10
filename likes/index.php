<?php 
require_once '../db_connect.php';
session_start();
//delete for ever movie from likes
if(array_key_exists('id_forever_movie',$_GET)){
    $req=$db->prepare('DELETE FROM likes WHERE id_movie=:idmovie and id_user=:id_user');
    $req->execute(['idmovie'=>$_GET['id_forever_movie'],'id_user'=>$_SESSION['iduser']]);
    header('location:index.php?msg=movie deleted&class=success');
}
//shows
//delete forever show
if(array_key_exists('id_forever_show',$_GET)){
    $req=$db->prepare('DELETE FROM likes_shows WHERE id_show=:idshow and id_user=:id_user');
    $req->execute(['idshow'=>$_GET['id_forever_show'],'id_user'=>$_SESSION['iduser']]);
    header('location:index.php?msg=show deleted&class=success');
}
?>