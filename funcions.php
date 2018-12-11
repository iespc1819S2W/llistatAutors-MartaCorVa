<?php

//Establir connexio
function conectar() {

    $host = "127.0.0.1";
    $user = "root";
    $passwd = "";
    $bbdd = "biblioteca";
    $mysqli = new mysqli($host, $user, $passwd, $bbdd);
    if (!$mysqli) {
        die("La conexio a bbdd ha fallat");
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}

//Generar select nacionalitats
function generaSelect($mysqli, $sql, $name, $key, $display, $selected, $null = true) {
    $cursor = $mysqli->query($sql) or die($sql);
    echo "<select name='$name' id='$name' form='segon'>";
    if ($null) {
        echo "<option value=''>Selecciona un valor</option>";
    }
    while ($row = $cursor->fetch_assoc()) {
        $sel = "";
        if ($row[$key] == $selected) {
            $sel = "selected";
        }
        echo "<option value='{$row[$key]}' $sel>";
        echo $row[$display];
        echo "</option>";
    }
    echo "</select>";
}

?>