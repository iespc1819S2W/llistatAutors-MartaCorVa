<?php

//Establir connexio

$host = "127.0.0.1";
$user = "root";
$pass = "";
$bd = "biblioteca";

$mysqli = new mysqli($host,$user,$pass,$bd);
if (!$mysqli){
    die("No hi ha connexio");
}

$mysqli->set_charset("utf8");

//query

$query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
$cursor = $mysqli ->query($query) or die($query);

while($row = $cursor->fetch_assoc()){
    echo "<tr>";
    echo "<td>" . $row['ID_AUT'] . " " . "</td>";
    echo "<td>" . $row['NOM_AUT'] . "</td><br/>";
    echo "</tr>";
}
        
?>

