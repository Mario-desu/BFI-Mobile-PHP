<?php
require_once("include/include_db.php");


//Link abfragen
if (   isset(  $_GET["token"]  ) ){
    
    
    //Den mit GET übertragenen Wert bereinigen, nur Buchstaben u. ZHalen erlaubt
    $token=preg_replace("/[^A-Za-z0-9]/", '', $_GET["token"] );
    
    
    $sql="UPDATE user SET userRole=1
    WHERE userToken=:token";
    
    
        $stmt=$db->prepare($sql);
        $stmt->bindParam(":token",$token); 
        
        $stmt->execute();
        $row=$stmt->fetch();
    //Weiterleitung zum Lgin
        header("location:projekt_login.php");
}

//http://localhost/testprojekt/projekt_email_verifizieren.php?token=785aa4bfd0cbe4dab10f9fb4bf60941a
//nach test/aus Mail rauskopieren

//einloggen
?>