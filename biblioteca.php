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

//Encontrar una coincidencia con el buscador

if (isset($_POST['cerca'])) {
    $cerca = $_POST['cerca'];
}

if (isset($_POST['consulta'])) {
    if (isset($_POST['cerca'])) {
        $cerca = trim($_POST['cerca']);
    } else {
        echo "No hi ha resultats a la BBDD";
    }
}

//Capçalera, select i cercar

echo "<html>";
echo "<meta charset='UTF-8'>";
echo "<title>Biblioteca</title>";
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "</head>";

echo "<body>";
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

//Total de pagines

$consulta_autors = "select count(*) as total from AUTORS where NOM_AUT like '%$cerca%' or ID_AUT like '%$cerca%' order by $ordena";
$rs_autors = $mysqli->query($consulta_autors) or die($consulta_autors);
if ($row = $rs_autors->fetch_assoc()) {
    $registres = $row['total'];
}

//Autors per pagina
$autors_pag = 10;


//Agafam el valor de pagina

$pagina = 1;

//Calcul de les pagines totals
$total_pagines = ceil($registres / $autors_pag);

//Botons

if (isset($_POST['pagina'])) {
    $pagina = $_POST['pagina'];
}

if (isset($_POST['seguent'])) {
    if ($pagina < $total_pagines) {
        $pagina++;
    }
}

if (isset($_POST['anterior'])) {
    if ($pagina > 1) {
        $pagina--;
    }
}

if (isset($_POST['primer'])) {
    $pagina = 1;
}

if (isset($_POST['darrer'])) {
    $pagina = $total_pagines;
}

$inici = ($pagina - 1) * $autors_pag;

//Executam la consulta

$consulta = "select ID_AUT,NOM_AUT from AUTORS where ID_AUT like '%$cerca%' or NOM_AUT like '%$cerca%' order by $ordena limit $inici, $autors_pag";
$cursor = $mysqli->query($consulta) or die($consulta);
?>

<form method="post">
    <input type='hidden' name='pagina' value=' <?= $pagina ?>'>
    <input type='hidden' name='cerca' value='<?= $cerca ?>'>
    <input type="submit" name='primer' value="<<">
    <input type="submit" name='anterior' value="<">
    <input type="submit" name='seguent' value=">">
    <input type="submit" name='darrer' value=">>">
</form>

<?php
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

echo $pagina . "/" . $total_pagines;
?>

</body>
</html>



