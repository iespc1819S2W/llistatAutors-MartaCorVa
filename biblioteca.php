<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Biblioteca</title>
        <style>
            table, td, th {    
                border: 1px solid #ddd;
                text-align: left;
            }

            table, form {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 15px;
            }

            header {
                float: left;
                width: 100%;
            }

            h1, img {
                float: left;
            }

        </style>
    </head>
    <body>
        <header>
            <img src="img/paucasesnoves.jpg" alt="Pau Casesnoves" width="150" height="120">
            <h1>Pau CasesNoves</h1>
        </header>
        <form action="biblioteca.php" method="post">
            <select name="ordre">
                <option value="">Elegeix l'ordre</option>
                <option value="codi">Segons el codi</option>
                <option value="nom">Segons el nom</option>
            </select>
            <input type="text" name="cerca">
            <input type="submit" name="boto" value="Enviar">
        </form>
    </body>
</html>


<?php
//Establir connexio

$host = "127.0.0.1";
$user = "root";
$pass = "";
$bd = "biblioteca";

$mysqli = new mysqli($host, $user, $pass, $bd);
if (!$mysqli) {
    die("No hi ha connexio");
}

$mysqli->set_charset("utf8");


if (isset($_POST['boto'])) {

//Ordenar la tabla segun las preferencias

    if (isset($_POST['ordre'])) {
        $ordre = $_POST['ordre'];
        switch ($ordre) {
            case 'codi':
                $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
                $cursor = $mysqli->query($query) or die($query);
                break;
            case 'nom':
                $ordreNom = "select NOM_AUT, ID_AUT from AUTORS order by NOM_AUT asc";
                $cursor = $mysqli->query($ordreNom) or die($ordreNom);
                break;
            default:
                $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
                $cursor = $mysqli->query($query) or die($query);
                break;
        }
    }
    
    //Encontrar una coincidencia con el buscador
    
} else {
    $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
    $cursor = $mysqli->query($query) or die($query);
}


echo "<br/><br/>";
echo "<table>";
echo "<tr>";
echo "<th>Codi</th>";
echo "<th>Nom</th>";
echo "</tr>";

while ($row = $cursor->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['ID_AUT'] . "</td>";
    echo "<td>" . $row['NOM_AUT'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>

