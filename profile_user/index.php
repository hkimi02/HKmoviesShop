<?php 
    require_once '../db_connect.php';
    session_start();
    //function to determine the number of hours and the number of minutes outta of number of minutes 
    function calculer_taille($nbminutes){
        $movie['nbheures']=((int)($nbminutes/60)).'h';
        $movie['nbminutes']=($nbminutes%60).'min';
        return $movie;
    }
    //deteremine genre of every movie starting from the forgein key on the table 
    function donner_genre($id_genre,$db){
        $req=$db->prepare('SELECT namegenre FROM genre WHERE idgenre=:id_genre');
        $req->execute(['id_genre'=>$id_genre]);
        $added_genre=$req->fetchAll();
        foreach($added_genre as $value){
        echo $value['namegenre']; 
    }
    }
    if(isset($_SESSION['username'])){
        //select liked movies not deleted
        $req=$db->prepare('SELECT m.* FROM movies m,likes l WHERE l.id_user=:id_user AND l.id_movie=m.idmovie AND l.garbage=0');
        $req->execute(['id_user'=>$_SESSION['iduser']]);
        $liked_movies=$req->fetchAll();
        //select deleted liked movies
        $req=$db->prepare('SELECT m.* FROM movies m,likes l WHERE l.id_user=:id_user AND l.id_movie=m.idmovie AND l.garbage=1');
        $req->execute(['id_user'=>$_SESSION['iduser']]);
        $deleted_liked_movies=$req->fetchAll();
        //restore movie 
        if(array_key_exists('id_restore_movie',$_GET)){
            $req=$db->prepare('UPDATE likes SET garbage=:garbage WHERE id_movie=:idmovie and id_user=:id_user');
            $req->execute(['garbage'=>0,'idmovie'=>$_GET['id_restore_movie'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=movie restored succesfuly&class=success');
        }
        //delete for ever movie from likes
        if(array_key_exists('id_forever_movie',$_GET)){
            $req=$db->prepare('DELETE FROM likes WHERE id_movie=:idmovie and id_user=:id_user');
            $req->execute(['idmovie'=>$_GET['id_forever_movie'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=movie deleted&class=success');
        }
        //move movie to recycle bin 
        if(array_key_exists('id_delete_movie',$_GET)){
            $req=$db->prepare('UPDATE likes SET garbage=:garbage WHERE id_movie=:idmovie AND id_user=:id_user');
            $req->execute(['garbage'=>1,'idmovie'=>$_GET['id_delete_movie'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=movie deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
        }
        //shows
        //select liked shows not deleted
        $req=$db->prepare('SELECT tv.* FROM tvshows tv,likes_shows l WHERE l.id_user=:id_user AND l.id_show=tv.idtvshow AND l.garbage=0');
        $req->execute(['id_user'=>$_SESSION['iduser']]);
        $liked_shows=$req->fetchAll();
        //select deleted liked shows
        $req=$db->prepare('SELECT tv.* FROM tvshows tv,likes_shows l WHERE l.id_user=:id_user AND l.id_show=tv.idtvshow AND l.garbage=1');
        $req->execute(['id_user'=>$_SESSION['iduser']]);
        $deleted_liked_shows=$req->fetchAll();
        //move shpw to recycle bin
        if(array_key_exists('id_delete_show',$_GET)){
            $req=$db->prepare('UPDATE likes_shows SET garbage=:garbage WHERE id_show=:idshow AND id_user=:id_user');
            $req->execute(['garbage'=>1,'idshow'=>$_GET['id_delete_show'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=show deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
        }
        //restore deleted liked show
        if(array_key_exists('id_restore_show',$_GET)){
            $req=$db->prepare('UPDATE likes_shows SET garbage=:garbage WHERE id_show=:idshow AND id_user=:id_user');
            $req->execute(['garbage'=>0,'idshow'=>$_GET['id_restore_show'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=show restored succesfuly&class=success');
        }
        //delete forever show
        if(array_key_exists('id_forever_show',$_GET)){
            $req=$db->prepare('DELETE FROM likes_shows WHERE id_show=:idshow and id_user=:id_user');
            $req->execute(['idshow'=>$_GET['id_forever_show'],'id_user'=>$_SESSION['iduser']]);
            header('location:index.php?msg=show deleted&class=success');
        }
        include './home.phtml';
    }else{
        header('location:../index.php?msg=you have to be loaged in to access your page&class=danger');
    }
