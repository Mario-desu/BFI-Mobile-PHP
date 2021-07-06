<?php
require_once("include/include_db.php");

// Standardsortierung festlegen
$feld="tarifID";
$sortierung="asc";


if(  isset($_GET["feld"]) &&  isset($_GET["sortierung"])   )
{
	$erlaubt=["tarifName", "tarifKategorie", "datenvolumenGB","freiMinuten","freiSMS","tarifPreis",
	"asc", "desc"];
	
	if(  in_array($_GET["feld"],$erlaubt)  &&   in_array($_GET["sortierung"],$erlaubt)   )
	{
		$feld=$_GET["feld"];
		$sortierung=$_GET["sortierung"];		
	}
	
}// isset ENDE




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
$sql="SELECT * FROM tarife WHERE tarifKategorie='Standard' ORDER BY $feld $sortierung";

$stmt=$db->query($sql);

$counter=0;

echo "<table class='table'>\n";

echo "<tr>\n";


echo "<th>Tarif<br>
<a href='?feld=tarifName&sortierung=asc'>&uArr;</a>
<a href='?feld=tarifName&sortierung=desc'>&dArr;</a>
</th>\n";
echo "<th>Kategorie<br>
<a href='?feld=artikelKategorie&sortierung=asc'>&uArr;</a>
<a href='?feld=artikelKategorie&sortierung=desc'>&dArr;</a>
</th>\n";
echo "<th>Datenvolumen GB<br>
<a href='?feld=datenvolumenGB&sortierung=asc'>&uArr;</a>
<a href='?feld=datenvolumenGB&sortierung=desc'>&dArr;</a>
</th>\n";
echo "<th>Minuten<br>
<a href='?feld=freiMinuten&sortierung=asc'>&uArr;</a>
<a href='?feld=freiMinuten&sortierung=desc'>&dArr;</a>
</th>\n";  
echo "<th>SMS<br>
<a href='?feld=freiSMS&sortierung=asc'>&uArr;</a>
<a href='?feld=freiSMS&sortierung=desc'>&dArr;</a>
</th>\n";    
echo "<th>Preis<br>
<a href='?feld=tariPreisf&sortierung=asc'>&uArr;</a>
<a href='?feld=tariPreis&sortierung=desc'>&dArr;</a>
</th>\n";   
     
echo "<th></th>\n"; 

echo "</tr>\n";	
	
while( $row=$stmt->fetch() )
{
	echo "<tr>\n";
	

	echo "<td class='alignRight'>$row[tarifName]</td>\n";
	echo "<td>$row[tarifKategorie]</td>\n";
    echo "<td>$row[datenvolumenGB]</td>\n";
    if ( "$row[freiMinuten]" < 1)
    {
        
        echo "<td></td>\n";
    }else {
        
        
    echo "<td>$row[freiMinuten]</td>\n";
    }
    if ( "$row[freiMinuten]" < 1)
    {
        
        echo "<td></td>\n";
    }else {
        
        
    echo "<td>$row[freiMinuten]</td>\n";
    }
	echo "<td class='alignRight'>".number_format($row["tarifPreis"], 2, ",", ".")."</td>\n";
   
 
    echo "<td><a href='tarif_unterseite.php?details=$row[tarifID]'>mehr Details</a></td>\n";
    
    
    
	echo "</tr>\n";
	$counter++;	
}
echo "</table>\n";
echo "$counter Tarife gefunden";

?>
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