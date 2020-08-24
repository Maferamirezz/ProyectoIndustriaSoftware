<?php

class Cliente{

   
    private $IDCLIENTE;
    private $NOMBRECLIENTE;
    private $ESTADO;
    private $DIRECCION;
    private $TELEFONO;
    private $TIPOCLIENTE;
    private $CODIGO;
    private $MENSAJE;
    
    public function __construct($IDCLIENTE,
                $NOMBRECLIENTE,
                $ESTADO,
                $DIRECCION,
                $TELEFONO,
                $TIPOCLIENTE
            
                ){
        $this->IDCLIENTE = $IDCLIENTE;
        $this->NOMBRECLIENTE = $NOMBRECLIENTE;
        $this->ESTADO = $ESTADO;
        $this->DIRECCION = $DIRECCION;
        $this->TELEFONO = $TELEFONO;
        $this->TIPOCLIENTE = $TIPOCLIENTE;
      
       
    }

        static function soloObjectoCliente()
	{
		    return new self('n' ,
            'n',
            'n',
            'n',
            'n',
            'n');
    } 


    public function getIDCLIENTE(){
        return $this->IDCLIENTE;
    }
    public function setIDCLIENTE($IDCLIENTE){
        $this->IDCLIENTE = $IDCLIENTE;
    }
    public function getNOMBRECLIENTE(){
        return $this->NOMBRECLIENTE;
    }
    public function setNOMBRECLIENTE($NOMBRECLIENTE){
        $this->NOMBRECLIENTE = $NOMBRECLIENTE;
    }
    public function getESTADO(){
        return $this->ESTADO;
    }
    public function setESTADO($ESTADO){
        $this->ESTADO = $ESTADO;
    }
    public function getDIRECCION(){
        return $this->DIRECCION;
    }
    public function setDIRECCION($DIRECCION){
        $this->DIRECCION = $DIRECCION;
    }
    public function getTELEFONO(){
        return $this->TELEFONO;
    }
    public function setTELEFONO($TELEFONO){
        $this->TELEFONO = $TELEFONO;
    }
    public function getTIPOCLIENTE(){
        return $this->TIPOCLIENTE;
    }
    public function setTIPOCLIENTE($TIPOCLIENTE){
        $this->TIPOCLIENTE = $TIPOCLIENTE;
    }

    public function getCODIGO(){
        return $this->CODIGO;
    }
    public function setCODIGO($CODIGO){
        $this->CODIGO = $CODIGO;
    }
    public function getMENSAJE(){
        return $this->MENSAJE;
    }
    public function setMENSAJE($MENSAJE){
        $this->MENSAJE = $MENSAJE;
    }

/*     public function __toString(){
        return 
            " NOMBRECLIENTE: " . $this->NOMBRECLIENTE . 
            " ESTADO: " . $this->ESTADO . 
            " DIRECCION: " . $this->DIRECCION . 
            " TELEFONO: " . $this->TELEFONO . 
            " TIPOCLIENTE: " . $this->TIPOCLIENTE ;

    } */

        public function obtenerClientes($conexion){
        

        $sql = "
        select 
         t1.idcliente,
         t1.nombrecliente,
         t1.estado,
         t1.direccion,
         t1.telefono,
                 
        (SELECT t3.tipocliente FROM tipocliente  t3 WHERE t3.idtipocliente = t1.tipocliente_idtipocliente),
        decode(t1.estado, 1, 'ACTIVO', 'INACTIVO') 
      
        from cliente t1 order by t1.idcliente desc"; 

        $query = oci_parse( $conexion->getConexion(),$sql);
	    oci_execute($query);         
            while (($row = oci_fetch_row($query)) != false) {
                echo   '
                <tr>
                        <td>' .$row[1]. '</td>
                        <td>' .$row[5]. '</td>
                        <td>' .$row[3]. '</td>
                        <td>' .$row[4]. '</td>
                        <td>' .$row[6]. '</td>                    
                        <td>
                        <div>  <button class="modal-trigger waves-light  waves-effect" 
                                    style="background-color:lightseagreen;"
                                    data-target="modal-cliente-editar" 
                                    onclick="abrirModal_clienteEditar ('.$row[0].')">Editar</button>
                                    </div>
                        </td>
                        <td>
                        <div><button class="modal-trigger waves-light  waves-effect" style="background-color:indianred;"
                        data-target="modal-cliente-eliminar"   
                        onclick="abrirModal_clienteEliminar('.$row[0].');">Eliminar</button>
                        </div>
                        </td>
                    </tr>';            
         }        

         oci_free_statement($query);
         $conexion->cerrarConexion(); 
    }

    public  function obtenerTipoCliente($conexion){        
        $sql = "Select t1.idtipocliente,
                         t1.tipocliente 
                 from tipocliente t1 ";      
        $query = oci_parse($conexion->getConexion(),$sql);
        oci_execute($query);
        while (($row = oci_fetch_row($query)) != false) {            
          echo  '<option value="'.$row[0].'">'. $row[1].'</option>';          
         };             
         oci_free_statement($query );
         $conexion->cerrarConexion(); 
}
    public function guardarCliente($conexion){
        $sql = sprintf(
           " DECLARE
           PCNOMBRECLIENTE VARCHAR2(200);
           PNESTADO FLOAT;
           PCDIRECCION VARCHAR2(200);
           PCTELEFONO VARCHAR2(200);
           PNIDTIPOCLIENTE NUMBER;
           PNCODIGO NUMBER;
           PCMENSAJE VARCHAR2(200);
         BEGIN
           PCNOMBRECLIENTE := '". $this->NOMBRECLIENTE ."';
           PNESTADO := 1;
           PCDIRECCION := '". $this->DIRECCION ."';
           PCTELEFONO := '". $this->TELEFONO ."';
           PNIDTIPOCLIENTE :=  ".$this->TIPOCLIENTE.";
         
           SP_REGISTRARCLIENTE(
             PCNOMBRECLIENTE => PCNOMBRECLIENTE,
             PNESTADO => PNESTADO,
             PCDIRECCION => PCDIRECCION,
             PCTELEFONO => PCTELEFONO,
             PNIDTIPOCLIENTE => PNIDTIPOCLIENTE,
             PNCODIGO => PNCODIGO,
             PCMENSAJE => PCMENSAJE
           );
    
         END;

              ");
        
              $conexion->ejecutarConsulta($sql);
              $this->MENSAJE='Cliente Registrado con exito.' ;
              $this->CODIGO=1 ;

    }

    public function obtenerCliente($conexion,$idCliente){       

        $sql = "
        select 
         t1.idcliente,
         t1.nombrecliente,
         t1.estado,
         t1.direccion,
         t1.telefono,     
         t1.tipocliente_idtipocliente,            
        (SELECT t3.tipocliente FROM tipocliente  t3 WHERE t3.idtipocliente = t1.tipocliente_idtipocliente),
        decode(t1.estado, 1, 'ACTIVO', 'INACTIVO')       
        from cliente t1 
        where t1.idcliente = $idCliente "; 
        $query = oci_parse( $conexion->getConexion(),$sql);
	    $query = oci_parse( $conexion->getConexion(),$sql);
        oci_execute($query); 
        
         while (($row = oci_fetch_row($query)) != false) {         
            $this->setIDCLIENTE( $row[0]);          
            $this->setNOMBRECLIENTE( $row[1]);  
            $this->setESTADO( $row[2]);  
            $this->setDIRECCION( $row[3]);  
            $this->setTELEFONO( $row[4]);  
            $this->setTIPOCLIENTE( $row[5]);  
           };   
         oci_free_statement($query);
         $conexion->cerrarConexion(); 
    }

    public function eliminarCliente($conexion,$idClienteEliminar){
        $sql = sprintf(
                "delete from cliente  where idcliente ='".$idClienteEliminar."'");            
        $query = oci_parse( $conexion->getConexion(),$sql);
        $result =  oci_execute($query); 
        oci_free_statement($query );        
        $conexion->cerrarConexion(); 
        $this->MENSAJE='Cliente eliminado con exito.' ;
        $this->CODIGO=1 ;
    }

    public function editarCliente($conexion){
        $sql = sprintf(
            "DECLARE
            PNIDCLIENTE NUMBER;
            PCNOMBRECLIENTE VARCHAR2(200);
            PNESTADO FLOAT;
            PCDIRECCION VARCHAR2(200);
            PCTELEFONO VARCHAR2(200);
            PNIDTIPOCLIENTE NUMBER;
            PNCODIGO NUMBER;
            PCMENSAJE VARCHAR2(200);
          BEGIN
            PNIDCLIENTE := ".$this->IDCLIENTE.";
            PCNOMBRECLIENTE := '".$this->NOMBRECLIENTE."';
            PNESTADO := ".$this->ESTADO.";
            PCDIRECCION := '".$this->DIRECCION."';
            PCTELEFONO := '".$this->TELEFONO."';
            PNIDTIPOCLIENTE := ".$this->TIPOCLIENTE.";
          
            SP_EDITARCLIENTE(
              PNIDCLIENTE => PNIDCLIENTE,
              PCNOMBRECLIENTE => PCNOMBRECLIENTE,
              PNESTADO => PNESTADO,
              PCDIRECCION => PCDIRECCION,
              PCTELEFONO => PCTELEFONO,
              PNIDTIPOCLIENTE => PNIDTIPOCLIENTE,
              PNCODIGO => PNCODIGO,
              PCMENSAJE => PCMENSAJE
            );
           
          END;
      ");
            
        $query = oci_parse($conexion->getConexion(),$sql);
        $result = oci_execute($query);
        

        if($result)  
            {  
                oci_commit($conexion->getConexion());
                $this->MENSAJE='Cliente editado con exito.' ;
                 $this->CODIGO=1 ;
            }
        $conexion->cerrarConexion(); 



        }
}
?>