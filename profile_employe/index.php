<?php 
    require_once '../db_connect.php';
    session_start();
    function calculer_taille($nbminutes){
        $movie['nbheures']=($nbminutes/60).'h';
        $movie['nbminutes']=($nbminutes%60).'min';
        return $movie;
    }
    function donner_genre($id_genre,$db){
        $req=$db->prepare('SELECT namegenre FROM genre WHERE idgenre=:id_genre');
        $req->execute(['id_genre'=>$id_genre]);
        $added_genre=$req->fetchAll();
        foreach($added_genre as $value){
        echo $value['namegenre']; 
    }
    }
    $req=$db->prepare('SELECT * FROM genre');
    $req->execute();
    $genres=$req->fetchAll();
    if(isset($_POST['add'])){
        extract($_POST);
        $id_employe=$_SESSION['iduser'];
        //avatar
    //check extantion
    $name_file = $_FILES['poster']['name'];
    $type = pathinfo($name_file, PATHINFO_EXTENSION);
    $type_dispo = ['png', 'jpg', 'jpeg', 'gif'];
    if (!in_array($type, $type_dispo)) {
        header("location:index.php?msg=poster extention is invalid&class=danger");
        exit;
    }
    $name_file = md5(mt_rand()) . '.' . $type;
    if (!move_uploaded_file($_FILES['poster']['tmp_name'], '../storage/movies_posters' . $name_file)) {
        header("location:index.php?msg=image not uploaded&class=danger");
        exit;
    }
    $poster = '../storage/movies_posters/' . $name_file;
    $req=$db->prepare('INSERT INTO movies (movie_name,director,descripition,link,length,poster,idgenre,idemploye)
                                    values(:movie_name,:director,:descripition,:link,:length,:poster,:id_genre,:id_employe)');
    $req->execute([
        'movie_name'=>$movie_name,
        'director'=>$director,
        'descripition'=>$description,
        'link'=>$link,
        'length'=>$length,
        'poster'=>$poster,
        'id_genre'=>$idgenre,
        'id_employe'=>$id_employe,
    ]);
    if($req){
        header('location:index.php?msg=the movie '.$movie_name.' has been added succesfuly&class=success');
    }
    }
    $req=$db->prepare('SELECT * FROM movies WHERE idemploye=:idemploye');
    $req->execute(['idemploye'=>$_SESSION['iduser']]);
    $addedmovies=$req->fetchAll();
    include './home.phtml';
