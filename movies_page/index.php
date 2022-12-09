<?php 
    require_once '../db_connect.php';
    session_start();
    //grab genre start by id_genre
    function donner_genre($id_genre,$db){
        $req=$db->prepare('SELECT namegenre FROM genre WHERE idgenre=:id_genre');
        $req->execute(['id_genre'=>$id_genre]);
        $added_genre=$req->fetchAll();
        foreach($added_genre as $value){
        echo $value['namegenre']; 
    }
    }
    //calculer taille film
    function calculer_taille($nbminutes){
        $movie['nbheures']=((int)($nbminutes/60)).'h';
        $movie['nbminutes']=($nbminutes%60).'min';
        return $movie;
    }
    if(isset($_SESSION['username'])){
        $filter='all';
        //grab all movies and shows from database
        $req=$db->prepare('SELECT * FROM movies WHERE garbage=0');
        $req->execute();
        $movies=$req->fetchAll();
        //grab all shows from database
        $req=$db->prepare('SELECT * FROM tvshows WHERE garbage=0');
        $req->execute();
        $shows=$req->fetchAll();
        //filter
        if(array_key_exists('filter',$_GET)){
            $filter=$_GET['filter'];
        }
        function check_liked_movie($db,$id_movie){
            $req=$db->prepare('SELECT * FROM LIKES WHERE id_movie=:id_movie AND id_user=:id_user');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_movie,
            ]);
            if($req->fetch()){
            return true;
            }else{
            return false;
        }
    }
    function check_liked_show($db,$id_show){
        $req=$db->prepare('SELECT * FROM likes_shows WHERE id_show=:id_movie AND id_user=:id_user');
        $req->execute([
            'id_user'=>$_SESSION['iduser'],
            'id_movie'=>$id_show,
        ]);
        if($req->fetch()){
        return true;
        }else{
        return false;
    }
}
        //movie 
        if(array_key_exists('id_fav_movie',$_GET)){
            $id_movie=$_GET['id_fav_movie'];
            $req=$db->prepare('SELECT * FROM LIKES WHERE id_movie=:id_movie AND id_user=:id_user');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_movie,
            ]);
            if($req->fetch()){
                $req=$db->prepare('DELETE FROM LIKES WHERE id_movie=:id_movie AND id_user=:id_user');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_movie,
            ]);
            if($req){
                header('location:index.php');
            }
            }else{
            $req=$db->prepare('INSERT INTO likes(id_user,id_movie,garbage) VALUES(:id_user,:id_movie,:garbage)');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_movie,
                'garbage'=>0,
            ]);
            if($req){
                header('location:index.php');
            }
        }
    }
        if(array_key_exists('id_fav_show',$_GET)){
            $id_show=$_GET['id_fav_show'];
            $req=$db->prepare('SELECT * FROM likes_shows WHERE id_show=:id_movie AND id_user=:id_user');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_show,
            ]);
            if($req->fetch()){
                $req=$db->prepare('DELETE FROM likes_shows WHERE id_show=:id_movie AND id_user=:id_user');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_movie'=>$id_show,
            ]);
            if($req){
                header('location:index.php');
            }
            }else{
            $req=$db->prepare('INSERT INTO likes_shows(id_user,id_show,garbage) VALUES(:id_user,:id_show,:garbage)');
            $req->execute([
                'id_user'=>$_SESSION['iduser'],
                'id_show'=>$id_show,
                'garbage'=>0,
            ]
        );
            if($req){
                header('location:index.php');
            }
        }
    }
    include './home.phtml';
    }else{
        header('location:../index.php?msg=you have to log in to acces movies page&class=danger');
    }
