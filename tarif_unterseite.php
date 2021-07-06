<?php
//Verbindung zur DB herstellen
require_once("include/include_db.php");



if(  isset( $_GET["details"]  )){
	//Aus der URL
	$tarifID=(int)$_GET["details"];//kommmt als umgewandelte Integer

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
	<title>Fairmobil</title>
	<link rel="stylesheet" href="css/style.css">
    
    
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
<?php

    
$sql="SELECT * FROM tarife 
WHERE tarifID=:tarifID";

$stmt=$db->prepare($sql);	
$stmt->bindParam(":tarifID",$tarifID);
$stmt->execute();

$row=$stmt->fetch();
echo "<h2>$row[tarifName]</h2>";    
echo "<ul>\n";    
echo "<li>$row[datenvolumenGB] GB</li>";
echo "<li>$row[freiMinuten] Minuten</li>";    
echo "<li>$row[freiSMS] SMS</li>";    
echo "</ul>";     
echo "<h3>€ $row[tarifPreis] pro Monat</h3>";    
echo "<br>";
echo "<a href='projekt_bestellung.php?bestellen=$row[tarifID]'><input type='submit' class='submit' value='Bestellen'></a>";    
?>
    

   
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