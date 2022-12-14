<?php 
    require_once '../db_connect.php';
    use PHPMailer\PHPMailer\PHPMailer;
    include "../send.php";
    session_start();
    function shows_number($db){
        $req=$db->prepare("SELECT count(tvshows.idtvshow) as nb_shows FROM tvshows");
        $req->execute();
        $res=$req->fetch();
        return $res['nb_shows'];
    }
    function movies_number($db){
        $req=$db->prepare("SELECT count(movies.idmovie) as nb_movie FROM movies");
        $req->execute();
        $res=$req->fetch();
        return $res['nb_movie'];
    }
    function products_number($db){
        return shows_number($db)+movies_number($db);
    }
    function total_users($db){
        $req=$db->prepare("SELECT count(iduser) as nb_user FROM users");
        $req->execute();
        $res=$req->fetch();
        return $res['nb_user'];
    }
    function total_employes($db){
        $req=$db->prepare("SELECT count(iduser) as nb_employe FROM users where isEmploye=1");
        $req->execute();
        $res=$req->fetch();
        return $res['nb_employe'];
    }
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
    if(isset($_SESSION['username']) && $_SESSION['isAdmin']==1){
        //select liked movies not deleted
        $req=$db->prepare('SELECT m.* FROM movies m,likes l WHERE l.id_user=:id_user AND l.id_movie=m.idmovie AND l.garbage=0');
    $req->execute(['id_user'=>$_SESSION['iduser']]);
$liked_movies=$req->fetchAll();
// var_dump($liked_movies);
// exit;
//select liked shows not deleted
$req=$db->prepare('SELECT tv.* FROM tvshows tv,likes_shows l WHERE l.id_user=:id_user AND l.id_show=tv.idtvshow AND l.garbage=0');
$req->execute(['id_user'=>$_SESSION['iduser']]);
$liked_shows=$req->fetchAll();
// var_dump($liked_shows);

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

// exit;
        //en cours demandes
    $req=$db->prepare('SELECT * FROM jobrequest WHERE STATE=0'); 
    $req->execute();
    $pending=$req->fetchAll();
    //declined deamndes
    $req=$db->prepare('SELECT * FROM jobrequest WHERE STATE=2'); 
    $req->execute();
    $declined=$req->fetchAll();
    //all job requests
      //declined deamndes
      $req=$db->prepare('SELECT * FROM jobrequest'); 
        $req->execute();
        $requests=$req->fetchAll();
    //employees 
    $req=$db->prepare('SELECT * FROM users WHERE isEmploye=:isemploye');
    $req->execute(['isemploye'=>1]);
    $employes=$req->fetchAll();
    if(array_key_exists('accept',$_GET)){
        $req=$db->prepare('SELECT * FROM jobrequest WHERE iddemande=:id_demande'); 
        $req->execute([
            'id_demande'=>$_GET['id_apply']
        ]);
        $accepted_demande=$req->fetch();
        $idapply=$accepted_demande['iddemande'];
        $email=$accepted_demande['email'];
        $token=$accepted_demande['token'];
        $link = "<a href='" . $_SERVER['HTTP_HOST'] . "/" . explode('/', $_SERVER['PHP_SELF'])[1] . 
        "/signupemploye/index.php?idapply=" . $idapply . "&email=" . $email . "&token=" . $token . ">
        click here so you can fill out the formr</a>";
        $body='<h1>welcome , we are very happy to inform you that your demande for a job at 
        HKmoviesShop has been accepted fill <br> out the form by clicking at the link so you can 
        finish the last step and became one of our family</h1>';
        sendmail('HKmoviesShop', $email, 'Lien de verifiaction', $body .'<br>' . $link . '');
        $req=$db->prepare('UPDATE jobrequest SET state=:state WHERE iddemande=:id');
        $req->execute(['state'=>1,'id'=>$idapply]);
        header('location:index.php?msg=state changed succesfuly !&type=success');
    }
if(array_key_exists('refuse',$_GET)){
    $req=$db->prepare('UPDATE jobrequest SET state=:state WHERE iddemande=:id');
    $req->execute(['state'=>2,'id'=>$_GET['id_apply']]);
    header('location:index.php?msg=state changed succesfuly !&type=success');
}
    include 'home.phtml';
    
}else{
    header('location:../index.php?msg=you have to log in to acces your page !&class=danger');
}