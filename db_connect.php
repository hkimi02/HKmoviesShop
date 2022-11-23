<?php 
   try{
    $db=new PDO('mysql:host=localhost;dbname=hkmoviesshop;charset=utf8','root','');
   }catch(Exception $e){
     echo 'connect failed' .$e->getMessage();
   }
?>
