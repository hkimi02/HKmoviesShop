<?php 
    require_once '../db_connect.php';
    if(isset($_POST['submit'])){
        extract($_POST);
        //check username length
        if(strlen($name)<4){
            header('location:index.php?msg=name length should be more than 4&class=danger');
            exit;
        }
        //check unique email
        $req=$db->prepare('SELECT email FROM jobrequest WHERE email=:email');
        $req->execute(['email'=>$email]);
        if($req->rowCount()){
                    header('location:index.php?msg=email already exists&class=danger');
                    exit;
        }
        //experience 
        if($experience=='yes'){
            $experience=1;
        }
        else{
            $experience=0;
        }
        //descripition 
        if(strlen($descripition)>1000){
            header('location:index.php?msg=your description shouldnt be more than 1000 letters&class=danger');
        }
        //cv
        //check extantion
        $name_file= $_FILES['cv']['name'];
        $type=pathinfo($name_file,PATHINFO_EXTENSION);
        if($type!='pdf'){
            header("location:index.php?msg=extention invalid we accept only .pdf files&class=danger");
            exit;
        }
        //move cv to the cv_demande folder in storage
        $name_file=md5(mt_rand()).'.'.$type;
        if(!move_uploaded_file($_FILES['cv']['tmp_name'],'../storage/'.$name_file)){
            header("location:index.php?msg=cv not uploaded&class=danger");
            exit;
        }
        $cv='./storage/cv_demande/'.$name_file;
        $req=$db->prepare('INSERT INTO jobrequest(name,email,experience,cv,description,state)
        VALUES(:name,:email,:experience,:cv,:descripition,:state)');
        $req->execute([
            'name'=>$name,
            'email'=>$email,
            'experience'=>$experience,
            'cv'=>$cv,
            'descripition'=>$descripition,
            'state'=>0,
        ]);
        header('location:index.php?msg=thank you for you interest in applying for a job in our shop we will reply to you by mail soon !&class=success');
    }
    show:
    include './home.phtml';
//state 0 en cours 1 accepted 2 not accepted