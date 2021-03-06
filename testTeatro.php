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
        $existeHorarioFuncion = false;
        echo "Ingrese el horario de la funcion" . "\n";
        echo "Hora: ";
        $horaFuncion = trim(fgets(STDIN));
        echo "Minutos: ";
        $minutosFuncion = trim(fgets(STDIN));
        //convierto el horario de comienzo de la nueva funcion a minutos
        $horarioFuncionEnMinutos = ($horaFuncion*60)+$minutosFuncion;
        for($cont2=0; $cont2<(count($coleccionFuncionesAuxiliar)); $cont2++){
            //convierto el horario de inicio de la funcion ACTUAL a minutos
            $horaInicioFuncion = ($coleccionFuncionesAuxiliar[$cont2]["horaInicioFuncion"]["hora"]*60)+$coleccionFuncionesAuxiliar[$cont2]["horaInicioFuncion"]["minutos"];
            //establezco el horario de finalizacion de la funcion actual en minutos
            $horaFinalizacion = $horaInicioFuncion + $coleccionFuncionesAuxiliar[$cont2]["duracion"];
            //reviso si el horario de la nueva funcion se encuentra entre el horario de comienzo y finalizacion de la funcion actual
            if(($horarioFuncionEnMinutos>=$horaInicioFuncion) && ($horarioFuncionEnMinutos<=$horaFinalizacion)){
                $existeHorarioFuncion = true;
            }
        }
        if($existeHorarioFuncion){
            echo "Ya hay una funcion en este horario, ingrese otro horario para esta funcion" . "\n";
        }else{
            echo "El horario esta disponible. Horario seteado para la funcion " . $nombreFuncion . "\n";
        }
    }while($existeHorarioFuncion);
    //creo el array de la funcion nueva para guardarla en la coleccion de funciones auxiliar
    $funcionNueva = array("nombre"=>$nombreFuncion, "precio"=>$precioFuncion, "horaInicioFuncion"=>array("hora"=>$horaFuncion,"minutos"=>$minutosFuncion), "duracion"=>$duracionFuncion);
    array_push($coleccionFuncionesAuxiliar, $funcionNueva);

    //creo el objeto funcion para poder almacenarlo en la coleccion de funciones
    $horaInicioFuncion = array("hora"=>$horaFuncion,"minutos"=>$minutosFuncion);
    $funcion = new Funcion($nombreFuncion, $horaInicioFuncion, $duracionFuncion, $precioFuncion);
    array_push($coleccionFunc, $funcion);

    //array de colecciones para devolverlas al programa principal y podes implementarlas
    $conjuntoColecciones = array("auxiliar"=>$coleccionFuncionesAuxiliar, "objeto"=>$coleccionFunc);
    return($conjuntoColecciones);
}

/**
 * 
*/
function verFunciones($teatroFunciones){
    echo "--------------FUNCIONES--------------" . "\n";
    echo $teatroFunciones->consultarFunciones();
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

//este for lo hice para crear las funciones y almacenarlas en la coleccionFunciones para poder crear el objeto teatro
for($cont=0; $cont<$cantFunciones; $cont++){
    $coleFuncionNormalAux = crearFuncion($coleccionFuncionesAux, $coleccionFunciones);
    $coleccionFuncionesAux=$coleFuncionNormalAux["auxiliar"];
    $coleccionFunciones=$coleFuncionNormalAux["objeto"];
}
//creo objeto teatro
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
            echo "------------------------------------" . "\n";
            break;
        case '4':
            do{
                $auxiliarFunciones = 0;
                $coleFuncionesTeatro=$teatro->getColeFunciones();

                echo "ELIJA QUE FUNCION DESEA CAMBIAR SUS ATRIBUTOS" . "\n";
                //muestro el nombre de todas las funciones
                for ($contadorVueltas=1; $contadorVueltas <= (count($coleFuncionesTeatro)) ; $contadorVueltas++) { 
                    echo $contadorVueltas . ": Funcion " . $coleFuncionesTeatro[$auxiliarFunciones]->getNombre() . "\n";
                    $auxiliarFunciones++;
                }
                echo count($coleFuncionesTeatro)+1 . ": CANCELAR" . "\n";
                echo "Opcion: ";
                $opcionFuncion = trim(fgets(STDIN));
                //entro a cambiar los datos de una funcion en caso de que no sea la opcion de CANCELAR
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
            verFunciones($teatro);
            break;
        case '6':
            $coleFuncionNormalAux=crearFuncion($coleccionFuncionesAux, $coleccionFunciones);
            $coleccionFuncionesAux=$coleFuncionNormalAux["auxiliar"];
            $coleccionFunciones=$coleFuncionNormalAux["objeto"];
            $teatro->setColeFunciones($coleccionFunciones);
            break;
    }
}while($opcion<>7);

