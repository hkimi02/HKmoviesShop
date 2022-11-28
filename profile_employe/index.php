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
    //deteremine all genres
    $req=$db->prepare('SELECT * FROM genre');
    $req->execute();
    $genres=$req->fetchAll();
    //grab the movies added by this employe
    $req=$db->prepare('SELECT * FROM movies WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye'=>$_SESSION['iduser'],'garbage'=>0]);
    $addedmovies=$req->fetchAll();
    //grab the tv shows added by this employe
    $req=$db->prepare('SELECT * FROM tvshows WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye'=>$_SESSION['iduser'],'garbage'=>0]);
    $addedshows=$req->fetchAll();
    //form manupulation
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
    if (!move_uploaded_file($_FILES['poster']['tmp_name'], '../storage/movies_posters/' . $name_file)) {
        header("location:index.php?msg=image not uploaded&class=danger");
        exit;
    }
    $poster = '../storage/movies_posters/' . $name_file;
    $req=$db->prepare('INSERT INTO movies (movie_name,director,descripition,link,length,poster,idgenre,idemploye,garbage)
                                            values(:movie_name,:director,:descripition,:link,:length,:poster,:id_genre,:id_employe,:garbage)');
    $req->execute([
        'movie_name'=>$movie_name,
        'director'=>$director,
        'descripition'=>$description,
        'link'=>$link,
        'length'=>$length,
        'poster'=>$poster,
        'id_genre'=>$idgenre,
        'id_employe'=>$id_employe,
        'garbage'=>0
    ]);
    if($req){
        header('location:index.php?msg=the movie '.$movie_name.' has been added succesfuly&class=success');
    }
    }
    if(isset($_POST['add_show'])){
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
    if (!move_uploaded_file($_FILES['poster']['tmp_name'], '../storage/show_posters/' . $name_file)) {
        header("location:index.php?msg=image not uploaded&class=danger");
        exit;
    }
    $poster = '../storage/show_posters/' . $name_file;
    $req=$db->prepare('INSERT INTO tvshows (name,director,description,link,poster,idgenre,idemploye,garbage)
                                            values(:show_name,:director,:descripition,:link,:poster,:id_genre,:id_employe,:garbage)');
    $req->execute([
        'show_name'=>$show_name,
        'director'=>$director,
        'descripition'=>$description,
        'link'=>$link,
        'poster'=>$poster,
        'id_genre'=>$idgenre,
        'id_employe'=>$id_employe,
        'garbage'=>0
    ]);
    if($req){
        header('location:index.php?msg=the show '.$show_name.' has been added succesfuly&class=success');
    }
    }
    if(array_key_exists('id_delete_movie',$_GET)){
        $req=$db->prepare('UPDATE movies SET garbage=:garbage WHERE idmovie=:idmovie');
        $req->execute(['garbage'=>1,'idmovie'=>$_GET['id_delete_movie']]);
        header('location:index.php?msg=movie deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
    }
    if(array_key_exists('id_delete_show',$_GET)){
        $req=$db->prepare('UPDATE tvshows SET garbage=:garbage WHERE idtvshow=:idtvshow');
        $req->execute(['garbage'=>1,'idtvshow'=>$_GET['id_delete_show']]);
        header('location:index.php?msg=show deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
    }
    include './home.phtml';
