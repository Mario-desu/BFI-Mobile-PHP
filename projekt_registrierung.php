<?php
require_once("include/include_db.php");// Verbindung zur DB


?>
<!DOCTYPE html>
<html>
<head>
	<title>Fairmobil</title>
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
            <div class="container-fluid">
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
       
<div id="wrapper">
  
<?php
    

    
    
//Hilfsvariablen
$anrede="";    
$familienName="";
$vorName="";
$strasse="";    
$hausNummer="";
$PLZ="";
$ort="";
$telefonNummer="";    
$email="";
$password1="";
$password2="";
$zustimmungAGB="";
$zustimmungDatenschutz="";

    
$ok=true;
$bericht="";

if(isset($_POST["absenden"]))//erst wenn Absenden gedrückt wird
{
	//Zuweisung an die Variablen
    $anrede=$_POST["anrede"];
	$familienName=strip_tags(  $_POST["familienName"]  );
    $vorName=strip_tags(  $_POST["vorName"]  );
    $strasse=strip_tags(  $_POST["strasse"]  );
    $hausNummer=strip_tags(  $_POST["hausNummer"]  );
    $plz=strip_tags(  $_POST["plz"]  );
    $ort=strip_tags(  $_POST["ort"]  );
    $telefonNummer=strip_tags(  $_POST["telefonNummer"]  );
	$email=$_POST["email"];
	$password1=$_POST["password1"];
	$password2=$_POST["password2"];
	
	//Prüfung ob AGB angehakt
	if(isset($_POST["zustimmungAGB"]))
	{
		$zustimmungAGB=$_POST["zustimmungAGB"];
	}
	else
	{
		$ok=false;
		$bericht .= "Sie müssen den AGB zustimmen!<br>";
	}

    //Prüfung ob Datenschutz angehakt
	if(isset($_POST["zustimmungDatenschutz"]))
	{
		$zustimmungDatenschutz=$_POST["zustimmungDatenschutz"];
	}
	else
	{
		$ok=false;
		$bericht .= "Sie müssen dem Datenschutz zustimmen!<br>";
	}
    
	//Prüfung ob Email
	if(filter_var($email, FILTER_VALIDATE_EMAIL)===false) // false=Datentyp
	{
		$ok=false;
		$bericht .= "Keine gültige Email!<br>";
	}

	//Prüfung PW Mind. 8 Zeichen hat
	if(strlen($password1) < 8)
	{
		$ok=false;
		$bericht .= "Das Passwort muss mind 8 Zeichen haben!<br>";
	}
	
	//Prüfung ob PW übereinstimmt
	if($password1<>$password2)
	{
		$ok=false;
		$bericht .= "Das Passwort stimmt nicht überein!<br>";
	}

    // Passwort-Check
    $muster1="/[A-Z]/";// muss vorkommen, egal wo
    $muster2="/[a-z]/";
    $muster3="/[0-9]/";
    $muster4="/[!?%#\.]/";

    if(
    preg_match($muster1,$password1) && 
    preg_match($muster2,$password1) && 
    preg_match($muster3,$password1) &&     
    preg_match($muster4,$password1)  )      
    {
	
    }
    else {
    $ok=false;
    $bericht .="Das Passwort braucht Kleinbuchstabe, Großbuchstabe, Zahl und Sonderzeichen!<br>";
    }    
    
    
    //Prüfung ob Email existiert
    $sql="select * FROM user
    WHERE userEmail=:email";
    
    //wenn jm von außen Daten eingibt, Prepared Stmt, gegen SQL-Injections
    
    $stmt=$db->prepare($sql);//noch nicht ausführen
    $stmt->bindParam(":email",$email); //das, was im Formular eingegeben wird,
    // ersetzt den PLatzhalter oben bei $sql, danach prüft es eingegebene Adresse
    $stmt->execute();// her wird es überprüft
    $row=$stmt->fetch(); //übernimmt alles von jew. User
    
    /*!==ungleich*/
    if($row !==false){
        $ok=false;
        $bericht .="User mit dieser Email existiert bereits!<br>";
    }
    
    
    
	//Wenn immer noch ok
	if($ok===true)
	{
		$bericht = "<h2>GRATULATION!</h2> Sie erhalten gleich eine E-mail. Bitte bestätigen Sie die Registrierung.<br><a href='projekt_login.php'>zum Login</a>";
        
        
		//hier kommt dann der DB-Eintrag
        
        
        
        
        $options=["cost"=>12]; 
        $password1=password_hash($password1, PASSWORD_BCRYPT, $options);//überschreiben (was, wie, wie oft)
        
        $userToken=md5(time());
        
        $userRole=0;        
        //am Anfang hat er noch USreRolle 0
            
       //Abstand nach user wichtig außer es ist in nächster ZEile 
        $sql="INSERT INTO user (anrede,familienName,vorName,userRole,strasse,hausNummer,plz,ort,telefonNummer,userEmail,userPassword,userToken)
        VALUES (:anrede,:familienName,:vorName,:userRole,:strasse,:hausNummer,:plz,:ort,:telefonNummer,:email,:password,:token)";
        //: platzhalter, bei $userName im Formular eingegebenes wird in Spalten in DB eingefügt
        // userToken neu wg. Verifizierung
        $stmt=$db->prepare($sql);
        $stmt->bindParam(":anrede",$anrede); 
        $stmt->bindParam(":familienName",$familienName); 
        $stmt->bindParam(":vorName",$vorName); 
        $stmt->bindParam(":userRole",$userRole); 
        $stmt->bindParam(":strasse",$strasse); 
        $stmt->bindParam(":hausNummer",$hausNummer); 
        $stmt->bindParam(":plz",$plz); 
        $stmt->bindParam(":ort",$ort); 
        $stmt->bindParam(":telefonNummer",$telefonNummer); 
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":password",$password1);
        $stmt->bindParam(":token",$userToken);
        $stmt->execute();
       
        
        // man will nach der Verifizierung Userrole 1 geben
    
        //Email zur Verifizierung
        
        $empfaenger = $email;
        $betreff = "Verifizierung $vorName $familienName";
        
        $nachricht = "Hallo\n";
        $nachricht .= "hier dein Link ";
        $nachricht .= "<a href='https://meinedomain.com/projekt_email_verifizieren.php?token=$userToken'>bitte klicken</a>";
        
        
        
        $header = 'From: mhartleb83@yahoo.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        mail($empfaenger, $betreff, $nachricht, $header);

        
		//entleerung des Formulars
		
        $anrede="";    
        $familienName="";
        $vorName="";
        $strasse="";    
        $hausNummer="";
        $plz="";
        $ort="";
        $telefonNummer="";    
        $email="";
        $password1="";
        $password2="";
        $zustimmungAGB="";
        $zustimmungDatenschutz="";
	}

}


//echo $bericht;
    
//Formular erscheint wieder nach absenden        
?>
<div class="container-fluid">
<?php   
    
echo $bericht;
 
?> 
<br>    
<h2>Registrierung</h2> 
<br>    
<form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);   ?>" method="post">
    
Anrede:<br>
<?php
$anrede= ["Frau","Herr"];    
    
    echo"<select name=anrede>\n";
    
    foreach($anrede as $element){
        
        echo"\t<option>$element</option>\n";
    }    
        echo"</select><br>";
    
    
    
?>
<br>    
Familienname:<br>    
<input type="text" class="form-control" name="familienName" value="<?php echo $familienName; ?>"><br>
<!--value, damit eingegebenes drinnen bleibt-->
Vorname:<br>
<input type="text" class="form-control" name="vorName" value="<?php echo $vorName; ?>"><br> 
Straße:<br>
<input type="text" class="form-control" name="strasse" value="<?php echo $strasse; ?>"><br> 
Hausnummer/Stiege/Tür:<br>
<input type="text" class="form-control" name="hausNummer" value="<?php echo $hausNummer; ?>"><br>  
PLZ:<br>
<input type="number" class="form-control" name="plz" value="<?php echo $plz; ?>"><br>
Ort:<br>
<input type="text" class="form-control" name="ort" value="<?php echo $ort; ?>"><br>
Telefonnummer:<br>
<input type="text" class="form-control" name="telefonNummer" value="<?php echo $telefonNummer; ?>"><br>
email:<br>    
<input type="email" class="form-control" name="email" value="<?php echo $email; ?>"><br>
<br>
Passwort:<br>
<input type="password" class="form-control" name="password1" value="<?php echo $password1; ?>"><br>
<br>
Passwort wiederholen:<br>
<input type="password" class="form-control" name="password2" value="<?php echo $password2; ?>"><br>
<br>
<input type="checkbox" name="zustimmungAGB" value="ok"<?php if($zustimmungAGB=="ok") { echo "checked"; } ?>>ich stimme den AGB zu<br>
    
<input type="checkbox" name="zustimmungDatenschutz" value="ok"<?php if($zustimmungDatenschutz=="ok") { echo "checked"; } ?>>ich stimme dem Datenschutz zu<br>


<br>
<input type="submit" class="submit" name="absenden" value="absenden"><br>

</form>
</div>
    <br>
    <br>
    <br>
    </div>
           <footer>
            <div class="container">
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
</body>
</html>