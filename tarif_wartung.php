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



//Wenn der Link zum Löschen geklickt wurde

if( isset(  $_GET["loeschen"]) ){
    
    //sofort in Zahl umwandeln
    $tarifID=(int)$_GET["loeschen"];
    
   
    $sql="DELETE FROM tarife WHERE tarifID=:tarifID";
    $abfrage=$db->prepare($sql);
    $abfrage->bindParam(":tarifID",$tarifID);
    $abfrage->execute();		

    header("location:$_SERVER[PHP_SELF]"); 
    // dass man wieder ganz oben landet auf Seite
  
}

//Anlegen neuer Artikel
if( isset(  $_POST["senden"]  )  )
{
	$tarifName=strip_tags( $_POST["tarifName"] )  ;
	$tarifKategorie=strip_tags( trim( $_POST["tarifKategorie"] )  );	
	$datenvolumenGB=strip_tags( trim( $_POST["datenvolumenGB"] )  );
    $freiMinuten=strip_tags( trim( $_POST["freiMinuten"] )  );
    $freiSMS=strip_tags( trim( $_POST["freiSMS"] )  );
	//Komma durch Punkt ersetzen
	$tarifPreis=str_replace(",", ".", $_POST["tarifPreis"]);
	
	$beschreibung= trim( $_POST["beschreibung"] );	
    
    if( isset(  $_POST["tarifStatus"]  )  ){
		$tarifStatus=1;
	}else{
		$tarifStatus=0;		
	}
	
		
	$sql="INSERT INTO 
    tarife (tarifName,tarifKategorie,datenvolumenGB,freiMinuten,freiSMS,tarifPreis,beschreibung,tarifStatus)
	VALUES
    (:tarifName,:tarifKategorie,:datenvolumenGB,:freiMinuten,:freiSMS,:tarifPreis,:beschreibung,:tarifStatus)";

	$abfrage=$db->prepare($sql);	
	$abfrage->bindParam(":tarifName",$tarifName);	
	$abfrage->bindParam(":tarifKategorie",$tarifKategorie);	
	$abfrage->bindParam(":datenvolumenGB",$datenvolumenGB);	
	$abfrage->bindParam(":freiMinuten",$freiMinuten);	
	$abfrage->bindParam(":freiSMS",$freiSMS);	
    $abfrage->bindParam(":tarifPreis",$tarifPreis);
    $abfrage->bindParam(":beschreibung",$beschreibung);
    $abfrage->bindParam(":tarifStatus",$tarifStatus);

	$abfrage->execute();		
	
    header("location:$_SERVER[PHP_SELF]"); 
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
Tarifname<br>
<input type="text" class="form-control" name="tarifName" required><br> <!--required=Pflichtfeld-->

Kategorie<br>
<?php
$tarifKategorie=["Standard","SIM Only","Telefonieren","Data Only"];

echo "<select name='tarifKategorie' class='form-control'>\n";
foreach($tarifKategorie as $element){
	echo "\t<option>$element</option>\n";
}
echo "</select><br>";
?>
Datenvolumen in GB<br>
<input type="number" class="form-control" min=0 name="datenvolumenGB"><br>
Freiminuten<br>
<input type="number" class="form-control" min=0 name="freiMinuten"><br>   
Frei-SMS<br>
<input type="number" class="form-control" min=0 name="freiSMS"><br>  
Tarifpreis<br>
<input type="text" class="form-control" min=0 name="tarifPreis"><br>    
Beschreibung<br>
<textarea class="form-control" name="beschreibung"></textarea><br>
<input type="checkbox" class="form-control" name="tarifStatus"><br>        
<input type="submit" class="form-control" name="senden" value="speichern"><br>
Tarifstatus<br>
    
</form>

<?php
$sql="SELECT * FROM tarife";

$stmt=$db->query($sql);

$counter=0;

echo "<table class='table'>\n";

echo "<tr>\n";

echo "<th>ID</th>\n";
echo "<th>Tarif</th>\n";
echo "<th>Kategorie</th>\n";
echo "<th>Datenvolumen GB</th>\n";
echo "<th>Minuten</th>\n";  
echo "<th>SMS</th>\n";    
echo "<th>Preis</th>\n";    
echo "<th>Beschreibung</th>\n";    
echo "<th></th>\n";  
echo "<th></th>\n";    

echo "</tr>\n";	
	
while( $row=$stmt->fetch() )
{
	echo "<tr>\n";
	
	echo "<td class='alignRight'>$row[tarifID]</td>\n";
	echo "<td>$row[tarifName]</td>\n";
	echo "<td>$row[tarifKategorie]</td>\n";
    echo "<td>$row[datenvolumenGB]</td>\n";
    echo "<td>$row[freiMinuten]</td>\n";
    echo "<td>$row[freiSMS]</td>\n";
	echo "<td class='alignRight'>".number_format($row["tarifPreis"], 2, ",", ".")."</td>\n";
    echo "<td>$row[beschreibung]</td>\n";
    echo"<td>
    <a href='?loeschen=$row[tarifID]' onclick='return testen()'>löschen</a></td>\n"; 
    echo "<td><a href='tarif_update.php?update=$row[tarifID]'>update</a></td>\n";
    
    
    
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
<script>
 "use strict"
    function testen(){
    return confirm("wollen Sie das wirklich löschen?")
    }   
    
    </script>     
    
</body>
</html>