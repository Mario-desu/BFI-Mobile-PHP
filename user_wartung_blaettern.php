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

require_once("include/include_db.php");




if(  isset($_POST["suche_senden"]) ){
        //Was über Suchfeld kommt
    $suche="%".strip_tags( $_POST["usersuche"])."%";// nach Suche wird vorne und hinten ein % angehängt
}else{
    // Beim ersten Aufruf
    $suche="%%"; // %% = sucht alles
}

// Standardsortierung festlegen
$feld="userID";
$sortierung="asc";


if(  isset($_GET["feld"]) &&  isset($_GET["sortierung"])   )
{
	$erlaubt=["userID", "anrede", "familienName","vorName","userRole","strasse","plz","ort",
	"asc", "desc"];
	// Nur wenn die übergebenen Felder und Sortierungen im erlaubt-Array
	// vorkommen, wird die Sortierung umgeschrieben
	if(  in_array($_GET["feld"],$erlaubt)  &&   in_array($_GET["sortierung"],$erlaubt)   )
	{
		$feld=$_GET["feld"];
		$sortierung=$_GET["sortierung"];
    }
}// isset ENDE    

// aktuelle Seite ermitteln
if(  isset($_GET["seite"])   )
{
	$seite=(int)$_GET["seite"];
}
else
{
	$seite=1;
}

// Anzahl der zu zeigenden Seiten festlegen
$eintraege_pro_seite=10;
// Startindex des 1. Datensatzes ermitteln

$start=$seite*$eintraege_pro_seite-$eintraege_pro_seite;



//Wenn der Link zum Löschen geklickt wurde

if( isset(  $_GET["loeschen"]) ){
    
    //sofort in Zahl umwandeln
    $userID=(int)$_GET["loeschen"];
    
   
    $sql="DELETE FROM user WHERE userID=:userID";
    $abfrage=$db->prepare($sql);
    $abfrage->bindParam(":userID",$userID);
    $abfrage->execute();		

    header("location:$_SERVER[PHP_SELF]"); 
    // dass man wieder ganz oben landet auf Seite
  
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
    
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="text" class="form-control" name="usersuche" placeholder="Familienname, Vorname, Ort, E-mail">
<br>    
<input type="submit" class="form-control" name="suche_senden" value="Suche">
    
</form>
<br>   
<br>
<?php
$sql="SELECT * FROM user
WHERE userID LIKE :suche OR familienName LIKE :suche OR vorName LIKE :suche OR ort LIKE :suche OR userEmail ORDER BY $feld $sortierung LIMIT :erster , :anzahl";
    
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);    

$stmt=$db->prepare($sql);
$stmt->bindParam(":suche",$suche);// :suche, was ins Suchfenster eingegeben wird //(Name etc.)
$abfrage->bindParam(":erster",$start);
$abfrage->bindParam(":anzahl",$eintraege_pro_seite);    
$stmt->execute();

$output=""; // output =freier Name, hier steht für das Angezeigte
$counter=0;    

	
$output="<table class='table'>\n";

$output.="<tr>\n";

$output.="<th>ID
<a href='?feld=userID&sortierung=asc'>&uArr;</a>
<a href='?feld=userID&sortierung=desc'>&dArr;</a>     
</th>\n";
$output.="<th>Anrede
<a href='?feld=anrede&sortierung=asc'>&uArr;</a>
    <a href='?feld=anrede&sortierung=desc'>&dArr;</a>
</th>\n";
$output.="<th>Familienname
<a href='?feld=familienName&sortierung=asc'>&uArr;</a>
<a href='?feld=familienName&sortierung=desc'>&dArr;</a>
</th>\n";
$output.="<th>Vorname
<a href='?feld=vorName&sortierung=asc'>&uArr;</a>
<a href='?feld=vorName&sortierung=desc'>&dArr;</a
</th>\n";  
$output.="<th>Userrole
<a href='?feld=userRole&sortierung=asc'>&uArr;</a>
<a href='?feld=userRole&sortierung=desc'>&dArr;</a>
</th>\n";    
$output.="<th>Straße
<a href='?feld=strasse&sortierung=asc'>&uArr;</a>
<a href='?feld=strasse&sortierung=desc'>&dArr;</a>
</th>\n";
$output.="<th>Hausnummer<br></th>\n";        
$output.="<th>PLZ
<a href='?feld=plz&sortierung=asc'>&uArr;</a>
<a href='?feld=plz&sortierung=desc'>&dArr;</a>
</th>\n";          
$output.="<th>Ort
<a href='?feld=ort&sortierung=asc'>&uArr;</a>
<a href='?feld=ort&sortierung=desc'>&dArr;</a>
</th>\n"; 
$output.="<th>Telefonnummer<br></th>\n";
$output.="<th>E-mail<br></th>\n";   
$output.="<th>Notizen<br></th>\n";
$output.="<th><br></th>\n";  
$output.="<th><br></th>\n"; 
        

$output.="</tr>\n";	
	
while( $row=$stmt->fetch() )
{
	$output.="<tr>\n";
	
	$output.="<td class='alignRight'>$row[userID]
      
    </td>\n";
	$output.="<td>$row[anrede]</td>\n";
	$output.="<td>$row[familienName]</td>\n";
    $output.="<td>$row[vorName]</td>\n";
    $output.="<td>$row[userRole]</td>\n";
    $output.="<td>$row[strasse]</td>\n";
    $output.="<td>$row[hausNummer]</td>\n";
    $output.="<td>$row[plz]</td>\n";
    $output.="<td>$row[ort]</td>\n";
    $output.="<td>$row[telefonNummer]</td>\n";
    $output.="<td>$row[userEmail]</td>\n";
	$output.="<td>$row[userText]</td>\n";
    $output.="<td><a href='?loeschen=$row[userID]' onclick='return testen()'>löschen</a></td>\n"; 
    $output.="<td><a href='user_update.php?update=$row[userID]'>update</a></td>\n";
    
    
    
	$output.="</tr>\n";
	$counter++;	
}
$output.="</table>\n";
$output.="$counter User gefunden";

echo $output;
    
// Ermitteln der Anzahl aller Datensätze und
// Erstellung der Seiten-Links

$sql="SELECT count(userID) as gesamt
FROM user";

$abfrage=$db->query($sql);
//nur 1 Ergebnis, keine Schleife nötig
$row=$abfrage->fetch();

$gesamt=$row["gesamt"];

// Anzahl der Seiten ermitteln

$wieviele_seiten=$gesamt/$eintraege_pro_seite;
//damit auf Seite, wo man ist, kein Hyperlink erstellt wird unten
//bei Seiten

for($zaehler=0;  $zaehler < $wieviele_seiten; $zaehler++)
{
	$seitennummer=$zaehler+1;
	
	// bin ich auf der aktuellen Seite?
	if($seite==$seitennummer)
	{
		echo " <strong>$seitennummer</strong> ";
	}
	else
	{
		echo " <a href='?seite=$seitennummer'>$seitennummer</a> ";
	}// if ENDE

}// for ENDE    

?>    

</div>	
    <br>
    <br>
    <br>    
<footer>
            <div class="container">
                <div class="footer-left">
                    <img src="bilder/fairmobil_logo_klein.png" alt="logo_klein">
                    <p>Fairer Mobilfunk</p>
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
<script>
 "use strict"
    function testen(){
    return confirm("wollen Sie das wirklich löschen?")
    }   
    
    </script>     
    
</body>
</html>