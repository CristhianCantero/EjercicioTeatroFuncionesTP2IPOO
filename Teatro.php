<?php

class Teatro{
    private $nombre;
    private $direccion;
    private $coleFunciones;
    
    public function __construct($nombre, $direccion, $coleFunciones)
    {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->coleFunciones = $coleFunciones;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getColeFunciones(){
        return $this->coleFunciones;
    }

    public function setNombre($n){
        $this->nombre = $n;
    }
    public function setDireccion($d){
        $this->direccion = $d;
    }
    public function setColeFunciones($coleFunc){
        $this->coleFunciones = $coleFunc;
    }

    public function cambiarNombre($nomb){
        $this->setNombre($nomb);
    }
    public function cambiarDireccion($dire){
        $this->setDireccion($dire);
    }
    public function consultarFunciones(){
        $auxiliarFunciones = 0;
        $coleccionFun = $this->getColeFunciones();
        $stringColecciones = "";
        for ($contadorVueltas=1; $contadorVueltas <= (count($coleccionFun)) ; $contadorVueltas++) { 
            $stringColecciones = $stringColecciones . $coleccionFun[$auxiliarFunciones] . "-------------------------------------" . "\n";
            // echo "-------------------------------------" . "\n";
            $auxiliarFunciones++;
        }
        return $stringColecciones;
    }
    
    public function __toString()
    {
        $funciones = $this->consultarFunciones();
        return ("Nombre del teatro: " . $this->getNombre() . "\n" .
                "Direccion del teatro: " . $this->getDireccion() . "\n" .
                "--------------FUNCIONES--------------" . "\n" . 
                $funciones
            );

    }
}
