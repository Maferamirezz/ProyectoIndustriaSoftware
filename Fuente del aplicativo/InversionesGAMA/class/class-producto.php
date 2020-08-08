<<?php

class Proveedor{

   
    private $RTNPROVEEDOR
    private $NOMBREPROVEEDOR;
    private $DIRECCION;
    private $EMAIL;
    private $TELEFONO;
    private $TIPOPRVEEDOR;
    
    public function __construct($RTNPROVEEDOR,
                $NOMBREPROVEEDOR,
                $DIRECCION,
                $EMAIL,
                $TELEFONO,
                $TIPOPRVEEDOR,
                ){
        $this->RTNPROVEEDOR = $codigoSeccion;
        $this->NOMBREPROVEEDOR = $NOMBREPROVEEDOR;
        $this->DIRECCION = $DIRECCION;
        $this->EMAIL = $EMAIL;
        $this->TELEFONO = $TELEFONO;
        $this->TIPOPRVEEDOR = $TIPOPRVEEDOR;
       
    }
    public function getRTNPRVEEDOR(){
        return $this->RTNPRVEEDOR;
    }
    public function setRTNPRVEEDOR($RTNPRVEEDOR){
        $this->RTNPRVEEDOR = $RTNPRVEEDOR;
    }
    public function getNOMBREPROVEEDOR(){
        return $this->NOMBREPROVEEDOR;
    }
    public function setNOMBREPROVEEDOR($NOMBREPROVEEDOR){
        $this->NOMBREPROVEEDOR = $NOMBREPROVEEDOR;
    }
    public function getDIRECCION(){
        return $this->DIRECCION;
    }
    public function setDIRECCION($hDIRECCION){
        $this->DIRECCION = $DIRECCION;
    }
    public function getEMAIL(){
        return $this->EMAIL;
    }
    public function setEMAIL($EMAIL){
        $this->EMAIL = $EMAIL;
    }
    public function getTELEFONO(){
        return $this->nombreTELEFONO;
    }
    public function setTELEFONO($TELEFONO){
        $this->TELEFONO = $TELEFONO;
    }
    public function getTIPOPRVEEDOR(){
        return $this->TIPOPRVEEDOR;
    }
    public function setTIPOPRVEEDOR($TIPOPRVEEDOR){
        $this->TIPOPRVEEDOR = $TIPOPRVEEDOR;
    }

    public function __toString(){
        return "RTNPROVEEDOR: " . $this->RTNPROVEEDOR . 
            " NOMBREPROVEEDOR: " . $this->NOMBREPROVEEDOR . 
            " DIRECCION: " . $this->DIRECCION . 
            " Descripcion: " . $this->Descripcion . 
            " EMAIL: " . $this->EMAIL . 
            " TIPOPRVEEDOR: " . $this->TIPOPRVEEDOR;
    }




    static public function obtenerSecciones($conexion,$RTNPROVEEDOR){
        

        $sql = "select* from seccion where RTNPROVEEDOR =".$RTNPROVEEDOR.""; 

      $resultado = $conexion->ejecutarConsulta($sql);
        while (($fila= $conexion->obtenerFila($resultado))) {
            
            $sql2="select count(*) Matriculas from DETALLEMATRICULA dm where codigoSeccion=".$fila["CODIGOSECCION"]."";
            $resultado2 = $conexion->ejecutarConsulta($sql2);
            $fila2 = $conexion->obtenerFila($resultado2);
            $cuposDisponibles = $fila["CUPOS"] - $fila2["MATRICULAS"];
            echo '<option value='.$fila['CODIGOSECCION'].'>Hora Inicio'.$fila['HORAINICIO'].' Hora FIN'.$fila['HORAFIN'].' Cupos:'.$cuposDisponibles.'</option>';
        }

    }




}
?>