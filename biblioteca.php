
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

if (isset($_POST['boto'])) {

//Ordenar la tabla segun las preferencias


    if (isset($_POST['ordre'])) {
        $ordre = $_POST['ordre'];
        switch ($ordre) {
            case 'codi':
                $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
                break;
            case 'codiDesc':
                $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT desc";
                break;
            case 'nom':
                $query = "select NOM_AUT, ID_AUT from AUTORS order by NOM_AUT asc";
                break;
            case 'nomDesc':
                $query = "select NOM_AUT, ID_AUT from AUTORS order by NOM_AUT desc";
                break;
            default:
                $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
                break;
        }
    }
} else {
    $query = "select NOM_AUT, ID_AUT from AUTORS order by ID_AUT asc";
}

//Encontrar una coincidencia con el buscador
if (isset($_POST['consulta'])) {
    if (isset($_POST['cerca'])) {
        $cerca = trim($_POST['cerca']);

        $queryCerca = "select * from AUTORS where NOM_AUT like '%" . $cerca . "%' or ID_AUT like '%" . $cerca . "%'";

        $registres = "select count(*) from AUTORS where NOM_AUT like '%" . $cerca . "%' or ID_AUT like '%" . $cerca . "%'";
        $cursor = $mysqli->query($registres) or die($registres);
        
        if ($registres > 0) {
            //Nombre de resultats trobats
            echo "<p>Hi ha " . $registres . " registres </p>";

            
        } else {
            echo "No hi ha resultats a la BBDD";
        }
    }
}

$cursor = $mysqli->query($query) or die($query);

//Capçelera, select i cercar

echo "<header>";
echo "<img src='img/paucasesnoves.jpg' alt='Pau Casesnoves' width='150' height='120'>";
echo "<h1>Pau CasesNoves</h1>";
echo "</header>";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Biblioteca</title>
        <link rel="stylesheet" type="text/css" href="style.css">  
    </head>
    <body>
        <form action="biblioteca.php" method="post">
            <select name="ordre">
                <option value="">Elegeix l'ordre</option>
                <option value="codi" <?php echo($ordre == "codi" ? "selected" : ""); ?>>Segons el codi ascendent</option>
                <option value="codiDesc" <?php echo($ordre == "codiDesc" ? "selected" : ""); ?>>Segons el codi descendent</option>
                <option value="nom" <?php echo($ordre == "nom" ? "selected" : ""); ?>>Segons el nom ascendent</option>
                <option value="nomDesc" <?php echo($ordre == "nomDesc" ? "selected" : ""); ?>>Segons el nom descendent</option>
            </select>
            <input type="submit" name="boto" value="Enviar">
            <input type="text" name="cerca">
            <input type="submit" name="consulta" value="Consultar">
        </form>
    </body>
</html>


<?php
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
    
