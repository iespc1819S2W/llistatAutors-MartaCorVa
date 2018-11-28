
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

$ordre = "";
$cerca = "";

if (isset($_POST['boto'])) {

//Ordenar la tabla segun las preferencias


    if (isset($_POST['ordre'])) {
        $ordre = $_POST['ordre'];
        switch ($ordre) {
            case 'codi':
                $ordena = "ID_AUT asc";
                break;
            case 'codiDesc':
                $ordena = "ID_AUT desc";
                break;
            case 'nom':
                $ordena = "NOM_AUT asc";
                break;
            case 'nomDesc':
                $ordena = "NOM_AUT desc";
                break;
            default:
                $ordena = "ID_AUT asc";
                break;
        }
    }
} else {
    $ordena = "ID_AUT asc";
}

//Capçalera, select i cercar

echo "<header>";
echo "<img src='img/paucasesnoves.jpg' alt='Pau Casesnoves' width='150' height='120'>";
echo "<h1>Pau CasesNoves</h1>";
echo "</header>";

echo "<form action='biblioteca.php' method='post'>";
echo "<select name='ordre'>";
echo "<option value=''>Elegeix l'ordre</option>";
echo "<option value='codi'" . ($ordena == "ID_AUT asc" ? "selected" : "") . ">Segons el codi ascendent</option>";
echo "<option value='codiDesc'" . ($ordena == "ID_AUT desc" ? "selected" : "") . ">Segons el codi descendent</option>";
echo "<option value='nom'" . ($ordena == "NOM_AUT asc" ? "selected" : "") . ">Segons el nom ascendent</option>";
echo "<option value='nomDesc'" . ($ordena == "NOM_AUT desc" ? "selected" : "") . ">Segons el nom descendent</option>";
echo "</select>";
echo "<input type='submit' name='boto' value='Enviar'>";
echo "<input type='text' name='cerca' value='$cerca'>";
echo "<input type='submit' name='consulta' value='Consultar'>";
echo "</form>";

echo "<br/><br/>";
echo "<table>";
echo "<tr>";
echo "<th>Codi</th>";
echo "<th>Nom</th>";
echo "</tr>";

//Encontrar una coincidencia con el buscador

if (isset($_POST['consulta'])) {
    if (isset($_POST['cerca'])) {
        $cerca = trim($_POST['cerca']);
    } else {
        echo "No hi ha resultats a la BBDD";
    }
} else {
    $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
}

$query = "select * from AUTORS where NOM_AUT like '%" . $cerca . "%' or ID_AUT like '%" . $cerca . "%' order by $ordena";
$cursor = $mysqli->query($query) or die($query);


while ($row = $cursor->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['ID_AUT'] . "</td>";
    echo "<td>" . $row['NOM_AUT'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Biblioteca</title>
        <link rel="stylesheet" type="text/css" href="style.css">  
    </head>
    <body>
        <form action="" method="post" id="hidden" enctype="multipart/form-data">		
            <input type="hidden" name="cerca" value="<?= $cerca ?>">
            <input type="hidden" name="ordre" value="<?= $ordre ?>">  
        </form>
    </body>
</html>