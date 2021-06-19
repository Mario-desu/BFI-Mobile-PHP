<?php
session_start();
session_regenerate_id(true);
if( empty(  $_SESSION["userID"]  ) ){
     header("location:projekt_registrierung.php");//wenn man ausgeloggt wird, landet man wieder beim LOgin
}

//Verbindung zur DB herstellen
require_once("include/include_db.php");



if(  isset( $_GET["bestaetigen"]  )){
	//Aus der URL
	$tarifID=(int)$_GET["bestaetigen"];//kommmt als umgewandelte Integer





    //was bei den einzelnen Feldern gewählt wird
	$userID=(int)$_SESSION["userID"];	
	
	
	
	/*//Tarifpreis aus DB
	$sql="SELECT tarifPreis FROM tarife
	WHERE tarifID = :tarifID";

	$stmt=$db->prepare($sql);
	$stmt->bindParam(":tarifID",$tarifID);
	$stmt->execute();
	$row=$stmt->fetch();

	$tarifPreis=$row["tarifPreis"];//Tarifpreis raussuchen
    
   */

	//Einfügen in die DB (Bestellungstabelle)
	$sql="INSERT INTO bestellungen
	(bestTarifBID,bestUserBID)
	VALUES
	(:bestTarifBID,:bestUserBID)";
	$stmt=$db->prepare($sql);
	$stmt->bindParam(":bestTarifBID",$tarifID);
	$stmt->bindParam(":bestUserBID",$userID);
	
	
	
	$stmt->execute();

}




?>
<!DOCTYPE html>
<html lang="de">
<head>
	<!-- für bootstrap -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheet.css">
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
    
<h1>Vielen Dank für Ihre Bestellung!</h1>    
<br> 
<br>    
<?php

    
$sql="SELECT * FROM tarife 
WHERE tarifID=:tarifID";

$stmt=$db->prepare($sql);	
$stmt->bindParam(":tarifID",$tarifID);
$stmt->execute();

$row=$stmt->fetch();
echo "<h3>Ihr Tarif:</h3>";  
echo "<br>";     
echo "<h4>$row[tarifName]</h4>";    
echo "<br>";
echo "<p>€ $row[tarifPreis] pro Monat</p>";
echo "<br>";
    
echo "<br>";   

$userID=$_SESSION["userID"];    
    
$sql="SELECT * FROM user 
WHERE userID=:userID";

$stmt=$db->prepare($sql);	
$stmt->bindParam(":userID",$userID);
$stmt->execute();

echo "<h3>Ihre Daten:</h3>";    
echo "<br>";    
$row=$stmt->fetch();
echo "<p>$row[anrede]<p>";    
echo "<p>$row[vorName] $row[familienName]<p>";   
echo "<p>$row[strasse] $row[hausNummer]<p>";
echo "<p>$row[plz] $row[ort]<p>";
echo "<p>$row[telefonNummer]<p>";
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
    

    


</form>    
    
<br>   
<br>
<br>
<br>
<a href="projekt_shop.php">zur Tarifübersicht</a>

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