<?php
require_once '../db_connect.php';

function shows_number($db)
{
    $req = $db->prepare("SELECT count(tvshows.idtvshow) as nb_shows FROM tvshows WHERE idemploye=:id_show");
    $req->execute(['id_show' => $_SESSION['iduser']]);
    $res = $req->fetch();
    return $res['nb_shows'];
}
function movies_number($db)
{
    $req = $db->prepare("SELECT count(movies.idmovie) as nb_movie FROM movies WHERE idemploye=:id");
    $req->execute(['id' => $_SESSION['iduser']]);
    $res = $req->fetch();
    return $res['nb_movie'];
}
function products_number($db)
{
    return movies_number($db) + shows_number($db);
}
session_start();
if (isset($_SESSION['username']) && $_SESSION['isEmploye'] == 1) {
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
    //select liked movies not deleted
    $req = $db->prepare('SELECT m.* FROM movies m,likes l WHERE l.id_user=:id_user AND l.id_movie=m.idmovie AND l.garbage=0');
    $req->execute(['id_user' => $_SESSION['iduser']]);
    $liked_movies = $req->fetchAll();
    //select liked shows not deleted
    $req = $db->prepare('SELECT tv.* FROM tvshows tv,likes_shows l WHERE l.id_user=:id_user AND l.id_show=tv.idtvshow AND l.garbage=0');
    $req->execute(['id_user' => $_SESSION['iduser']]);
    $liked_shows = $req->fetchAll();
    //function to determine the number of hours and the number of minutes outta of number of minutes 
    function calculer_taille($nbminutes)
    {
        $movie['nbheures'] = ((int)($nbminutes / 60)) . 'h';
        $movie['nbminutes'] = ($nbminutes % 60) . 'min';
        return $movie;
    }
    //deteremine genre of every movie starting from the forgein key on the table 
    function donner_genre($id_genre, $db)
    {
        $req = $db->prepare('SELECT namegenre FROM genre WHERE idgenre=:id_genre');
        $req->execute(['id_genre' => $id_genre]);
        $added_genre = $req->fetchAll();
        foreach ($added_genre as $value) {
            echo $value['namegenre'];
        }
    }
    //deteremine all genres
    $req = $db->prepare('SELECT * FROM genre');
    $req->execute();
    $genres = $req->fetchAll();
    //grab the movies added by this employe
    $req = $db->prepare('SELECT * FROM movies WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye' => $_SESSION['iduser'], 'garbage' => 0]);
    $addedmovies = $req->fetchAll();
    //grab the tv shows added by this employe
    $req = $db->prepare('SELECT * FROM tvshows WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye' => $_SESSION['iduser'], 'garbage' => 0]);
    $addedshows = $req->fetchAll();
    //grab the recycle bin from both tables
    $req = $db->prepare('SELECT * FROM tvshows WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye' => $_SESSION['iduser'], 'garbage' => 1]);
    $deletedshows = $req->fetchAll();
    $req = $db->prepare('SELECT * FROM movies WHERE idemploye=:idemploye and garbage=:garbage');
    $req->execute(['idemploye' => $_SESSION['iduser'], 'garbage' => 1]);
    $deletedmovies = $req->fetchAll();
    //form manupulation
    if (isset($_POST['add'])) {
        extract($_POST);
        $id_employe = $_SESSION['iduser'];
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
        $req = $db->prepare('INSERT INTO movies (movie_name,director,descripition,link,length,poster,idgenre,idemploye,garbage)
                                            values(:movie_name,:director,:descripition,:link,:length,:poster,:id_genre,:id_employe,:garbage)');
        $req->execute([
            'movie_name' => $movie_name,
            'director' => $director,
            'descripition' => $description,
            'link' => $link,
            'length' => $length,
            'poster' => $poster,
            'id_genre' => $idgenre,
            'id_employe' => $id_employe,
            'garbage' => 0
        ]);
        if ($req) {
            header('location:index.php?msg=the movie ' . $movie_name . ' has been added succesfuly&class=success');
        }
    }
    if (isset($_POST['add_show'])) {
        extract($_POST);
        $id_employe = $_SESSION['iduser'];
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
        $req = $db->prepare('INSERT INTO tvshows (name,director,description,link,poster,idgenre,idemploye,garbage)
                                            values(:show_name,:director,:descripition,:link,:poster,:id_genre,:id_employe,:garbage)');
        $req->execute([
            'show_name' => $show_name,
            'director' => $director,
            'descripition' => $description,
            'link' => $link,
            'poster' => $poster,
            'id_genre' => $idgenre,
            'id_employe' => $id_employe,
            'garbage' => 0
        ]);
        if ($req) {
            header('location:index.php?msg=the show ' . $show_name . ' has been added succesfuly&class=success');
        }
    }
    if (array_key_exists('id_delete_movie', $_GET)) {
        $req = $db->prepare('UPDATE movies SET garbage=:garbage WHERE idmovie=:idmovie');
        $req->execute(['garbage' => 1, 'idmovie' => $_GET['id_delete_movie']]);
        header('location:index.php?msg=movie deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
    }
    if (array_key_exists('id_restore_movie', $_GET)) {
        $req = $db->prepare('UPDATE movies SET garbage=:garbage WHERE idmovie=:idmovie');
        $req->execute(['garbage' => 0, 'idmovie' => $_GET['id_restore_movie']]);
        header('location:index.php?msg=movie restored succesfuly&class=success');
    }
    if (array_key_exists('id_delete_show', $_GET)) {
        $req = $db->prepare('UPDATE tvshows SET garbage=:garbage WHERE idtvshow=:idtvshow');
        $req->execute(['garbage' => 1, 'idtvshow' => $_GET['id_delete_show']]);
        header('location:index.php?msg=show deleted succesfuly you can find it at your recycle bin where you can delete it premantly or restore it&class=success');
    }
    if (array_key_exists('id_restore_show', $_GET)) {
        $req = $db->prepare('UPDATE tvshows SET garbage=:garbage WHERE idtvshow=:idtvshow');
        $req->execute(['garbage' => 0, 'idtvshow' => $_GET['id_restore_show']]);
        header('location:index.php?msg=show restored succesfuly&class=success');
    }
    include './home.phtml';
} else {
    header('location:index.php?msg=you have to be loaged in to access this page&class=success');
}
