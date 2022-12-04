<?php 
    require_once '../db_connect.php';
    use PHPMailer\PHPMailer\PHPMailer;
    include "../send.php";
    session_start();
    if(isset($_SESSION['username'])){
    //en cours demandes
    $req=$db->prepare('SELECT * FROM jobrequest WHERE STATE=0'); 
    $req->execute();
    $encours=$req->fetchAll();
    //declined deamndes
    $req=$db->prepare('SELECT * FROM jobrequest WHERE STATE=2'); 
    $req->execute();
    $declined=$req->fetchAll();
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
        "/signupemploye/index.php?idapply=" . $idapply . "&email=" . $email . "&token=" . $token . "'>click here so you can fill out the formr</a>";
        $body='welcome , we are very happy to inform you that your demande for a job at HKmoviesShop has been accepted fill <br> out the form by clicking at the link so you can finish the last step and became one of our family';
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