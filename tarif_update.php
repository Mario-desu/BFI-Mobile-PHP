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
	$tarifID=(int)$_GET["update"];//kommmt als umgewandelte Integer
//bei Update brauch man ID Feld
}

if(  isset( $_POST["update"]  )){// speichern-button
	//Aus dem Formular
	$tarifID=(int)$_POST["tarifID"];//kommt als umgewandelte integer
}
//Update Start
//Wenn Formular abgesendet wurde
if(  isset( $_POST["update"]  )){

	$tarifName=htmlspecialchars(trim( $_POST["tarifName"] ));
	$tarifKategorie=htmlspecialchars(trim( $_POST["tarifKategorie"] ));
    $datenvolumenGB=htmlspecialchars(trim( $_POST["datenvolumenGB"] ));
    $freiMinuten=htmlspecialchars(trim( $_POST["freiMinuten"] ));
    $freiSMS=htmlspecialchars(trim( $_POST["freiSMS"] ));
	$tarifPreis=htmlspecialchars(trim( $_POST["tarifPreis"] ));
	//Komma durch Punkt ersetzen
	//Was wird ersetzt, wodurch, wo
	$tarifPreis=str_replace("," ,".", $tarifPreis);
	
	$beschreibung=trim( $_POST["beschreibung"] );
	//wenn Hakerl gesetzt, dann wird gepostet
	if( isset( $_POST["tarifStatus"]  )  ){
		$tarifStatus=1;
	}else{
		$tarifStatus=0;		
	}
	//bei Update muss man alle Felder einzeln eingeben
	$sql="UPDATE tarife SET
	tarifName=:tarifName,
	tarifKategorie=:tarifKategorie,
    datenvolumenGB=:datenvolumenGB,
    freiMinuten=:freiMinuten,
    freiSMS=:freiSMS,
	tarifPreis=:tarifPreis,
	beschreibung=:beschreibung,
	tarifStatus=:tarifStatus 
	WHERE tarifID=:tarifID
	"; // vor WHERE kein Beistrich
	
	$stmt=$db->prepare($sql);
	$stmt->bindParam(":tarifID",$tarifID);
	$stmt->bindParam(":tarifName",$tarifName);
	$stmt->bindParam(":tarifKategorie",$tarifKategorie);
    $stmt->bindParam(":datenvolumenGB",$datenvolumenGB);
    $stmt->bindParam(":freiMinuten",$freiMinuten);
    $stmt->bindParam(":freiSMS",$freiSMS);
	$stmt->bindParam(":tarifPreis",$tarifPreis);
	$stmt->bindParam(":beschreibung",$beschreibung);
	$stmt->bindParam(":tarifStatus",$tarifStatus);
	
	$stmt->execute();
	$info="Tarif gespeichert!";
    
}//update Ende

?>
<!DOCTYPE html>
<html lang="de">
<head>
	<!-- für bootstrap -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<!-- für bootstrap -->
	<title>FairMobil</title>
	<link rel="stylesheet" href="stylesheet.css">
    
    <script type="text/javascript" src="./tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
		selector: "textarea",
		toolbar: "fontsizeselect",
		fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",	
		 plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor"
		],	
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons font_formats",	
	});
	</script>
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
echo "<h3>$info</h3>";    //Info, dass gespeichert
echo "<br>";    
//Zum Befüllen des Formulars
$sql="SELECT * FROM tarife 
WHERE tarifID=:tarifID";

$stmt=$db->prepare($sql);	
$stmt->bindParam(":tarifID",$tarifID);
$stmt->execute();
//keine  Schleife nötig, da nur 1 Artikel abgefragt wird
$row=$stmt->fetch();
echo "<h1>$row[tarifName] ändern</h1>";
  
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

TarifID<br>
<input type="text" class="form-control" 
value="<?php echo $row["tarifID"];  ?>" 
name="tarifID" readonly><br> <!--verhindert unabsichtliche eingeben-->


Tarifname<br>
<input type="text" class="form-control" 
value="<?php echo $row["tarifName"];  ?>" 
name="tarifName"><br>

Kategorie<br>
<?php
$tarifKategorie=["Standard","SIM Only","Telefonieren","Data Only"];

echo "<select name='tarifKategorie' class='form-control'>\n";
foreach($tarifKategorie as $element){
	//Vorauswahl der Artikelgruppe
	if($element==$row["tarifKategorie"]){
		$selected="selected"; 
	}else{
		$selected="";		//Vorauswahl wird gefüllt
	}

	echo "\t<option $selected>$element</option>\n";
}
echo "</select><br>";
?>

    
Datenvolumen in GB<br>
<input type="number" class="form-control" 
value="<?php echo $row["datenvolumenGB"]?>" 
name="datenvolumenGB"><br> 

Freiminuten<br>
<input type="number" class="form-control" 
value="<?php echo $row["freiMinuten"]?>" 
name="freiMinuten"><br> 
    
Frei-SMS<br>
<input type="number" class="form-control" 
value="<?php echo $row["freiSMS"]?>" 
name="freiSMS"><br>
    
Tarifpreis<br>
<input type="text" class="form-control" 
value="<?php echo number_format($row["tarifPreis"],2,",","");  ?>" 
name="tarifPreis"><br>

Beschreibung<br>
<textarea class="form-control" name="beschreibung"><?php echo $row["beschreibung"]  ?></textarea><br> 
    

Tarifstatus<br>
<input type="checkbox" class="form-control" name="tarifStatus"
<?php if($row["tarifStatus"]==1){echo "checked";}  ?>
><br>

<input type="submit" class="form-control" name="update" value="speichern"><br>
</form>

<a href="tarif_wartung.php">zur Tarifübersicht</a>

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