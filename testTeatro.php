<?php
include 'Teatro.php';
include 'Funciones.php';

/**
 * @param array $coleccionFuncionesAuxiliar, $coleccionFunc
 * @return array
*/
function crearFuncion($coleccionFuncionesAuxiliar, $coleccionFunc){
    echo "Ingrese el nombre de la funcion: ";
    $nombreFuncion = trim(fgets(STDIN));
    echo "Ingrese el precio de la funcion " . $nombreFuncion . ": ";
    $precioFuncion = trim(fgets(STDIN));
    echo "Ingrese la duracion de la funcion en minutos: ";
    $duracionFuncion = trim(fgets(STDIN));

    do {
        print_r($coleccionFuncionesAuxiliar);
        $existeHorarioFuncion = false;
        echo "Ingrese el horario de la funcion" . "\n";
        echo "Hora: ";
        $horaFuncion = trim(fgets(STDIN));
        echo "Minutos: ";
        $minutosFuncion = trim(fgets(STDIN));

        for($cont2=0; $cont2<(count($coleccionFuncionesAuxiliar)); $cont2++){
            if($coleccionFuncionesAuxiliar[$cont2]["horaInicioFuncion"]["hora"]==$horaFuncion){
                if($coleccionFuncionesAuxiliar[$cont2]["horaInicioFuncion"]["minutos"]==$minutosFuncion){
                    $existeHorarioFuncion = true;
                }
            }
        }
        if($existeHorarioFuncion){
            echo "Ya hay una funcion en este horario, ingrese otro horario para esta funcion" . "\n";
        }else{
            echo "El horario esta disponible. Horario seteado para la funcion " . $nombreFuncion . "\n";
        }
    }while($existeHorarioFuncion);

    $horaInicioFuncion = array("hora"=>$horaFuncion,"minutos"=>$minutosFuncion);
    
    $funcionNueva = array("nombre"=>$nombreFuncion, "precio"=>$precioFuncion, "horaInicioFuncion"=>array("hora"=>$horaFuncion,"minutos"=>$minutosFuncion), "duracion"=>$duracionFuncion);
    array_push($coleccionFuncionesAuxiliar, $funcionNueva);
    
    $funcion = new Funcion($nombreFuncion, $horaInicioFuncion, $duracionFuncion, $precioFuncion);

    array_push($coleccionFunc, $funcion);

    $conjuntoColecciones = array("auxiliar"=>$coleccionFuncionesAuxiliar, "objeto"=>$coleccionFunc);
    return($conjuntoColecciones);
}

/**
 * @param array $coleFuncionesTeatro
*/
function verFunciones($coleFuncionesTeatro){
    $auxiliarFunciones = 0;
    echo "--------------FUNCIONES--------------" . "\n";
    for ($contadorVueltas=1; $contadorVueltas <= (count($coleFuncionesTeatro)) ; $contadorVueltas++) { 
        echo $coleFuncionesTeatro[$auxiliarFunciones];
        echo "-------------------------------------" . "\n";
        $auxiliarFunciones++;
    }
}

/**
 * PROGRAMA PRINCIPAL
*/
echo "Ingrese el nombre del teatro: ";
$nombreTeatro = trim(fgets(STDIN));
echo "Ingrese la direccion del teatro: ";
$direccionTeatro = trim(fgets(STDIN));

echo "Ingrese cuantas funciones hay en el teatro: ";
$cantFunciones = trim(fgets(STDIN));

$coleccionFuncionesAux[] = array("nombre"=>'base', "precio"=>'0', "horaInicioFuncion"=>array("hora"=>0,"minutos"=>0), "duracion"=>'0');//inicializo el array para poder buscar en la primera vuelta si hay alguna funcion en el horario indicado

$coleccionFunciones = array();

for($cont=0; $cont<$cantFunciones; $cont++){
    $coleFuncionNormalAux = crearFuncion($coleccionFuncionesAux, $coleccionFunciones);
    $coleccionFuncionesAux=$coleFuncionNormalAux["auxiliar"];
    $coleccionFunciones=$coleFuncionNormalAux["objeto"];
}

$teatro = new Teatro($nombreTeatro, $direccionTeatro, $coleccionFunciones);

do {
    echo "ELIJA UNA OPCION: " . "\n";
    echo "1: Cambiar nombre del teatro" . "\n";
    echo "2: Cambiar direccion del teatro" . "\n";
    echo "3: Ver informacion completa del teatro" . "\n";
    echo "4: Cambiar nombre y precio de alguna funcion" . "\n";
    echo "5: Ver solo funciones" . "\n";
    echo "6: Agregar una nueva funcion" . "\n";
    echo "7: SALIR" . "\n";
    echo "Opcion: ";
    $opcion = trim(fgets(STDIN));
    switch ($opcion) {
        case '1':
            echo "Nombre actual: " . $teatro->getNombre() . "\n";
            echo "Ingrese el nuevo nombre: ";
            $nuevoNombreTeatro = trim(fgets(STDIN));
            $teatro->cambiarNombre($nuevoNombreTeatro);
            echo "---------INFORMACION TEATRO---------"  . "\n";
            echo $teatro;
            echo "------------------------------------" . "\n";
            break;
        case '2':
            echo "Direccion actual: " . $teatro->getDireccion() . "\n";
            echo "Ingrese la nueva direccion: ";
            $nuevaDireccionTeatro = trim(fgets(STDIN));
            $teatro->cambiarDireccion($nuevaDireccionTeatro);
            echo "---------INFORMACION TEATRO---------" . "\n";
            echo $teatro;
            echo "------------------------------------" . "\n";
            break;
        case '3':
            echo "---------INFORMACION TEATRO---------"  . "\n";
            echo $teatro;
            verFunciones($teatro->getColeFunciones());
            echo "------------------------------------" . "\n";
            break;
        case '4':
            do{
                $auxiliarFunciones = 0;
                $coleFuncionesTeatro=$teatro->getColeFunciones();

                echo "ELIJA QUE FUNCION DESEA CAMBIAR SUS ATRIBUTOS" . "\n";

                for ($contadorVueltas=1; $contadorVueltas <= (count($coleFuncionesTeatro)) ; $contadorVueltas++) { 
                    echo $contadorVueltas . ": Funcion " . $coleFuncionesTeatro[$auxiliarFunciones]->getNombre() . "\n";
                    $auxiliarFunciones++;
                }
                echo count($coleFuncionesTeatro)+1 . ": CANCELAR" . "\n";
                echo "Opcion: ";
                $opcionFuncion = trim(fgets(STDIN));
                if($opcionFuncion<>count($coleFuncionesTeatro)+1){
                    echo "Nombre funcion " . $opcionFuncion . " actual: " . $coleFuncionesTeatro[($opcionFuncion-1)]->getNombre() . "\n";
                    echo "Precio funcion " . $opcionFuncion . " actual: " . $coleFuncionesTeatro[($opcionFuncion-1)]->getPrecio() . "\n";
                    echo "Ingrese el nuevo nombre de la funcion " . $opcionFuncion . ": ";
                    $nuevoNombreFuncion = trim(fgets(STDIN));
                    echo "Ingrese el nuevo precio de la funcion " . $opcionFuncion . ": ";
                    $nuevoPrecioFuncion = trim(fgets(STDIN));
                    $coleFuncionesTeatro[($opcionFuncion-1)]->setNombre($nuevoNombreFuncion);
                    $coleFuncionesTeatro[($opcionFuncion-1)]->setPrecio($nuevoPrecioFuncion);
                }
            }while($opcionFuncion<>count($coleFuncionesTeatro)+1);
            break;
        case '5':
            verFunciones($teatro->getColeFunciones());
            break;
        case '6':
            $coleFuncionNormalAux=crearFuncion($coleccionFuncionesAux, $coleccionFunciones);
            $coleccionFuncionesAux=$coleFuncionNormalAux["auxiliar"];
            $coleccionFunciones=$coleFuncionNormalAux["objeto"];
            $teatro->setColeFunciones($coleccionFunciones);
            break;
    }
}while($opcion<>7);

