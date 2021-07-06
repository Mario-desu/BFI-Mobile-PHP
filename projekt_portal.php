<?php
session_start();
session_regenerate_id(true);
//Wenn session leer (niemand angelmeldet), dann Weiterleitung zum Logout
if( empty(  $_SESSION["userID"]  ) ){
     header("location:projekt_logout.php");//wenn man ausgeloggt wird, landet man wieder beim LOgin
}
require_once("include/include_db.php");
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
<div class="container">     
<?php
echo "Willkommen $_SESSION[vorName] $_SESSION[familienName]<br>";

    

echo "<br>\n";   
    if ( $_SESSION["userRole"] >1 ) {
        echo "<a href='projekt_admin.php'>Adminbereich</a>";
    }
echo "<br>\n";      
echo "<a href='projekt_shop.php'>zum Shop</a>";    
?>
    <br>
    <br>
    <br>
    <br>
   <a href='projekt_logout.php'>abmelden</a>
    <br>
    <br>
    
    </div>
    
    <footer>
            <div class="container-fluid">
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