<?php
session_start();
session_regenerate_id(true);
require_once "include/include_db.php";

$ok=true;
$bericht="";

if(  isset(  $_POST["senden"]  )  )
{
    //Prüfung auf Email
    if( filter_var( $_POST["email"], FILTER_VALIDATE_EMAIL ) !==false)
        // wenn nicht false, dann sinnvoller Inhalt
        
    {//Prüfung ob user existiert
    $sql="select * FROM user
    WHERE userEmail=:email AND userRole>=1"; 
    
    
    $stmt=$db->prepare($sql);
    $stmt->bindParam(":email", $_POST["email"]); //"post" 
        //ersetzt durch $email
        //bist du e-mail?
    $stmt->execute();
    $row=$stmt->fetch(); 
        
    //wenn der User existiert machen wir das:
    
    if($row !==false){
        
        //Password-Check
        

        
        if(  password_verify( $_POST["password"],  $row["userPassword"])  )
    {
            //User erkannt
            $_SESSION["userID"]=$row["userID"];
            $_SESSION["familienName"]=$row["familienName"];
            $_SESSION["vorName"]=$row["vorName"];
            $_SESSION["userRole"]=$row["userRole"];
            //Weiterleitung
            header("location:projekt_portal.php");
        
    }else {
            $ok=false;
            $bericht="<h4>Passwort ist falsch!</h4>";  
            
        }
        
        
        //PW-Ende
        
    }//Prüfung User Ende
        
       
        //mit echo "ok"; dazwischen prüfen
    }//filter Email Ende
    
}//senden Ende
    


    
?>
<!DOCTYPE html>
<html>
<head>
	<title>FairMobil</title>
    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheet.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<!-- für bootstrap -->
	
</head>
<body>
    <header>
            <div class="container">
                <div class="header-left">
                    <div class="header-logo">
                        <a href="index.php"><img src="bilder/fairmobil_logo_weiss.png" alt="Logo"></a>
                    </div>
                    </div>
                <div class="header-right">
                    <a href="projekt_portal.php">Kundenkonto</a>
                </div>
            </div>
        </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
<div class="container-fluid">     
<h2>Login</h2>  
<br>

<?php  
echo $bericht;
?>
<form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>" method="post">
email:<br><input type="email" class="form-control" name="email"><br>
password:<br><input type="password" class="form-control" name="password"><br>
<br> 
 
<br>    
<input type="submit" class="submit" name="senden">
    
</form>
<br>
<br>    
<a href="projekt_registrierung.php">Registrierung</a>    
    
    <br>
    <br>
    <br>
               <footer>
            <div>
                <div class="footer-left">
                    
                    <img src="bilder/fairmobil_logo_klein.png" alt="logo-klein">
                    <p>Transparenter Mobilfunk</p>
                    
                </div>
                <div class="footer-right">
                    
                    <ul>
                        <li>Kontakt</li>
                        <li>AGB</li>
                        <li>Impressum</li>
                    </ul>
                
                </div>
            </div>
            
        </footer>
</div>    
    
</body>
</html>