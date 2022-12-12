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
    if(array_key_exists('id_show',$_GET)){
        $req=$db->prepare('SELECT * from tvshows where idtvshow=:id_show AND idemploye=:id_employe');
        $req->execute([
            'id_show'=>$_GET['id_show'],
            'id_employe'=>$_SESSION['iduser'],
        ]);
        $show=$req->fetch();
        $req=$db->prepare('SELECT * FROM genre');
        $req->execute();
        $genres=$req->fetchAll();
        include 'home.phtml';
    }
    if(isset($_POST['update'])){
        var_dump('salemm');
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
        if (!move_uploaded_file($_FILES['poster']['tmp_name'], '../storage/show_posters/' . $name_file)) {
            header("location:index.php?msg=image not uploaded&class=danger");
            exit;
        }
        $poster = '../storage/show_posters/' . $name_file;
        }else{
            $poster=$old_poster;
        }
        $req=$db->prepare('UPDATE tvshows SET name=:show_name ,director=:director ,description=:description,link=:link,
        poster=:poster,idgenre=:id_genre WHERE idtvshow=:id_show');
        $req->execute([
            'show_name'=>$show_name,
            'director'=>$director,
            'description'=>$description,
            'link'=>$link,
            'poster'=>$poster,
            'id_genre'=>$idgenre,
            'id_show'=>$id_show
        ]);
        header("location:../profile_employe/index.php?msg=show info updated succesfuly&class=success");
    }
?>
