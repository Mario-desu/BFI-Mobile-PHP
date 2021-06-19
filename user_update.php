<?php
session_start();
session_regenerate_id(true);
//Wenn session leer (niemand angelmeldet), dann Weiterleitung zum Logout
if( empty(  $_SESSION["userID"] ) ){
     header("location:projekt_logout.php");
}
//Überprüfung der Rolle, mit Userole 2, sonst fliegt man raus
if ( $_SESSION["userRole"] <2 ) {
        
    
    header("location:projekt_shop.php");  
    
    }

//Verbindung zur DB herstellen
require_once("include/include_db.php");

$info="";

if(  isset( $_GET["update"]  )){
	//Aus der URL
	$userID=(int)$_GET["update"];//kommmt als umgewandelte Integer
//bei Update brauch man ID Feld
}

if(  isset( $_POST["update"]  )){// speichern-button
	//Aus dem Formular
	$userID=(int)$_POST["userID"];//kommt als umgewandelte integer
}
//Update Start
//Wenn Formular abgesendet wurde
if(  isset( $_POST["update"]  )){

	$anrede=htmlspecialchars(trim( $_POST["anrede"] ));
	$familienName=htmlspecialchars(trim( $_POST["familienName"] ));
    $vorName=htmlspecialchars(trim( $_POST["vorName"] ));
    $userRole=htmlspecialchars(trim( $_POST["userRole"] ));
    $strasse=htmlspecialchars(trim( $_POST["strasse"] ));
	$hausNummer=htmlspecialchars(trim( $_POST["hausNummer"] ));
	$plz=htmlspecialchars(trim( $_POST["plz"] ));
    $ort=htmlspecialchars(trim( $_POST["ort"] ));
    $telefonNummer=htmlspecialchars(trim( $_POST["telefonNummer"] ));
    $email=htmlspecialchars(trim( $_POST["email"] ));
    $notizen=htmlspecialchars(trim( $_POST["notizen"] ));
	
	
	//bei Update muss man alle Felder einzeln eingeben
	$sql="UPDATE user SET
	anrede=:anrede,
	familienName=:familienName,
    vorName=:vorName,
    userRole=:userRole,
    strasse=:strasse,
	hausNummer=:hausNummer,
	plz=:plz,
	ort=:ort,
    telefonNummer=:telefonNummer,
    userEmail=:email,
    userText=:notizen
	WHERE userID=:userID"; // vor WHERE kein Beistrich
	
	$stmt=$db->prepare($sql);
	$stmt->bindParam(":userID",$userID);
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
	$stmt->bindParam(":notizen",$notizen);
	
	$stmt->execute();
	$info="<h2>Änderungen gespeichert!</h2>";
    
}//update Ende

?>
<!DOCTYPE html>
<html lang="de">
<head>
	<!-- für bootstrap -->
	<meta charset="utf-8">
    <link rel="stylesheet" href="stylesheet.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<!-- für bootstrap -->
	<title>FairMobil</title>
	<link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <header>
    
            <div class="container">
                <div class="header-left">
                    <div class="header-logo">
                        <a href="http://localhost/testprojekt/"><img src="bilder/fairmobil_logo_weiss.png" alt="Logo"></a>
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
<a href="user_wartung.php">zurück zur Userliste</a>
    <br>
<?php
echo $info;    //Info, dass gespeichert
    
echo "<br>";  
    
//Zum Befüllen des Formulars
$sql="SELECT * FROM user 
WHERE userID=:userID";

$stmt=$db->prepare($sql);	
$stmt->bindParam(":userID",$userID);
$stmt->execute();
//keine  Schleife nötig, da nur 1 Artikel abgefragt wird
$row=$stmt->fetch();
//echo "<h2>$row[FamilienName] ändern</h2>";
  
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

UserID<br>
<input type="number" class="form-control" 
value="<?php echo $row["userID"];  ?>" 
name="userID" readonly><br> <!--verhindert unabsichtliche eingeben-->
    
Anrede<br>
<?php
$anrede=["Frau","Herr"];

echo "<select name='anrede' class='form-control'>\n";
foreach($anrede as $element){
	if($element==$row["anrede"]){
		$selected="selected"; 
	}else{
		$selected="";		//Vorauswahl wird gefüllt
	}

	echo "\t<option $selected>$element</option>\n";
}
echo "</select><br>";
?>    


Familienname<br>
<input type="text" class="form-control" 
value="<?php echo $row["familienName"];  ?>" 
name="familienName"><br>

Vorname<br>
<input type="text" class="form-control" 
value="<?php echo $row["vorName"];  ?>" 
name="vorName"><br>

Userrole<br>
<input type="number" class="form-control" min=0
value="<?php echo $row["userRole"]?>" 
name="userRole"><br> 

Straße<br>
<input type="text" class="form-control" 
value="<?php echo $row["strasse"]?>" 
name="strasse"><br> 
    
Hausnummer<br>
<input type="text" class="form-control" 
value="<?php echo $row["hausNummer"]?>" 
name="hausNummer"><br>
    
PLZ<br>
<input type="number" class="form-control" min=1010 
value="<?php echo $row["plz"]?>" 
name="plz"><br>    

Ort<br>
<input type="text" class="form-control" 
value="<?php echo $row["ort"]?>" 
name="ort"><br> 
    
Telefonnummer<br>
<input type="text" class="form-control" 
value="<?php echo $row["telefonNummer"]?>" 
name="telefonNummer"><br>
    
E-mail<br>
<input type="text" class="form-control" 
value="<?php echo $row["userEmail"]?>" 
name="email"><br>    

Notizen<br>
<textarea class="form-control" name="notizen"><?php echo $row["userText"]?></textarea><br> 
    

<input type="submit" class="form-control" name="update" value="speichern"><br>
</form>


</div>
    <br>
    <br>
    <br>    
    
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