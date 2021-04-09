<?php
class Funcion{
    private $nombre;
    private $horaInicio = array();
    private $duracionObra;
    private $precio;

    public function __construct($nombre, $horaInicio, $duracionObra, $precio)
    {
        $this->nombre = $nombre;
        $this->horaInicio = array(
            "hora"=> $horaInicio['hora'],
            "minutos"=> $horaInicio['minutos']
        );
        $this->duracionObra = $duracionObra;
        $this->precio = $precio;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getHoraInicio(){
        return $this->horaInicio;
    }
    public function getDuracionObra(){
        return $this->duracionObra;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setNombre($nom){
        $this->nombre=$nom;
    }
    public function setHoraInicio($horaIni){
        $this->horaInicio=$horaIni;
    }
    public function setDuracionObra($duraObra){
        $this->duracionObra=$duraObra;
    }
    public function setPrecio($pre){
        $this->precio=$pre;
    }

    public function cambiarFuncion($funcion){
        $this->setNombre($funcion["nombre"]);
        $this->setPrecio($funcion["precio"]);
    }
    public function mostrarHorarioFuncion(){
        $hora = $this->getHoraInicio();
        echo $hora['hora'] . ":" . $hora['minutos'];
    }

    public function __toString()
    {  
        $horario = $this->getHoraInicio();
        return  "Nombre de la funcion: " . $this->getNombre() . "\n" .
                "Precio de la funcion: " . $this->getPrecio() . "\n" .
                "Hora de inicio de la funcion: " . $horario['hora'] . ":" . $horario['minutos'] . "\n" .
                "Duracion de la funcion: " . $this->getDuracionObra() . " minutos" . "\n"
                ;
    }
}




