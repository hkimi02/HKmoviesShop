<?php 
require_once '../db_connect.php';
    session_start();
    function donner_genre($id_genre, $db)
    {
        $req = $db->prepare('SELECT namegenre FROM genre WHERE idgenre=:id_genre');
        $req->execute(['id_genre' => $id_genre]);
        $added_genre = $req->fetchAll();
        foreach ($added_genre as $value) {
            echo $value['namegenre'];
        }
    }
    if(array_key_exists('id_movie',$_GET)){
        $req=$db->prepare('SELECT * from movies where idmovie=:id_movie AND idemploye=:id_employe');
        $req->execute([
            'id_movie'=>$_GET['id_movie'],
            'id_employe'=>$_SESSION['iduser'],
        ]);
        $movie=$req->fetch();
        include 'home.phtml';
    }
    if(isset($_POST['update'])){
        extract($_POST);
        $id_employe=$_SESSION['iduser'];
        if(!empty($_FILES['poster']['name'])){
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
        }else{
            $poster=$old_poster;
        }
        $req=$db->prepare('UPDATE movies SET movie_name=:movie_name ,director=:director ,descripition=:descripition,link=:link,
        length=:length,poster=:poster,idgenre=:id_genre WHERE idmovie=:id_movie');
        $req->execute([
            'movie_name'=>$movie_name,
            'director'=>$director,
            'descripition'=>$description,
            'link'=>$link,
            'length'=>$length,
            'poster'=>$poster,
            'id_genre'=>$idgenre,
            'id_movie'=>$id_movie
        ]);
        header("location:../profile_employe/index.php?msg=movie info updated succesfuly&class=success");
    }
?>
