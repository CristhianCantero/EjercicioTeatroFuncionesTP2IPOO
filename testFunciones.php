<?php
include 'Funciones.php';

/**
 * Programa principal
*/

$nombre = "Tito1";
$horaI = array("hora"=>15, "minutos"=>30); //array para poder almacenar la hora y minutos por separado
$duracion = 115; //la duracion se establece en minutos
$precio = 650;

$funcion = new Funcion($nombre, $horaI, $duracion, $precio);

echo $funcion;

