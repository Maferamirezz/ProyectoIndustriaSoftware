<?php

class Producto{

   
    private $IDPRODUCTO;
    private $NOMBREPRODUCTO;
    private $CANTIDADDISPONIBLE;
    private $PRECIOCOSTO;
    private $IMPUESTO15;
    private $IMPUESTO18;
    private $DESCUENTO;
    private $PRECIOVENTA;
    private $ESTADO;
    private $TIPOPRODUCTO_IDPRODUCTO;
    private $codigoResultado;
    private $mensaje;
    
    public function __construct($IDPRODUCTO,
                                $NOMBREPRODUCTO,
                                $CANTIDADDISPONIBLE,
                                $PRECIOCOSTO,
                                $IMPUESTO15,
                                $IMPUESTO18,
                                $DESCUENTO,
                                $PRECIOVENTA,
                                $ESTADO,
                                $TIPOPRODUCTO_IDPRODUCTO
                ){
        $this->IDPRODUCTO = $IDPRODUCTO;
        $this->NOMBREPRODUCTO = $NOMBREPRODUCTO;
        $this->CANTIDADDISPONIBLE = $CANTIDADDISPONIBLE;
        $this->PRECIOCOSTO = $PRECIOCOSTO;
        $this->IMPUESTO15 = $IMPUESTO15;
        $this->IMPUESTO18 = $IMPUESTO18;
        $this->DESCUENTO = $DESCUENTO;
        $this->PRECIOVENTA = $PRECIOVENTA;
        $this->ESTADO = $ESTADO;
        $this->TIPOPRODUCTO_IDPRODUCTO = $TIPOPRODUCTO_IDPRODUCTO;
       
    }

    static function soloObjectoProducto()
	{
		return new self('n' ,
        'n',
        'n',
        'n',
        'n',
        'n',
        'n',
        'n',
        'n',
        'n'
    );
    }
    public function getIDPRODUCTO(){
        return $this->IDPRODUCTO;
    }
    public function setIDPRODUCTO($IDPRODUCTO){
        $this->IDPRODUCTO = $IDPRODUCTO;
    }
    public function getNOMBREPRODUCTO(){
        return $this->NOMBREPRODUCTO;
    }
    public function setNOMBREPRODUCTO($NOMBREPRODUCTO){
        $this->NOMBREPRODUCTO = $NOMBREPRODUCTO;
    }
    public function getCANTIDADDISPONIBLE(){
        return $this->CANTIDADDISPONIBLE;
    }
    public function setCANTIDADDISPONIBLE($CANTIDADDISPONIBLE){
        $this->CANTIDADDISPONIBLE = $CANTIDADDISPONIBLE;
    }
    public function getPRECIOCOSTO(){
        return $this->PRECIOCOSTO;
    }
    public function setPRECIOCOSTO($PRECIOCOSTO){
        $this->PRECIOCOSTO = $PRECIOCOSTO;
    }
    public function getIMPUESTO15(){
        return $this->IMPUESTO15;
    }
    public function setIMPUESTO15($IMPUESTO15){
        $this->IMPUESTO15 = $IMPUESTO15;
    }
    public function getIMPUESTO18(){
        return $this->IMPUESTO18;
    }
    public function setIMPUESTO18($IMPUESTO18){
        $this->IMPUESTO18 = $IMPUESTO18;
    }
    public function getDESCUENTO(){
        return $this->DESCUENTO;
    }
    public function setDESCUENTO($DESCUENTO){
        $this->DESCUENTO = $DESCUENTO;
    }
    public function getPRECIOVENTA(){
        return $this->PRECIOVENTA;
    }
    public function setPRECIOVENTA($PRECIOVENTA){
        $this->PRECIOVENTA = $PRECIOVENTA;
    }
    public function getESTADO(){
        return $this->ESTADO;
    }
    public function setESTADO($ESTADO){
        $this->ESTADO = $ESTADO;
    }
    public function getTIPOPRODUCTO_IDPRODUCTO(){
        return $this->TIPOPRODUCTO_IDPRODUCTO;
    }
    public function setTIPOPRODUCTO_IDPRODUCTO($TIPOPRODUCTO_IDPRODUCTO){
        $this->TIPOPRODUCTO_IDPRODUCTO = $TIPOPRODUCTO_IDPRODUCTO;
    }

    public function getCodigoResultado(){
        return $this->codigoResultado;
    }
    public function setCodigoResultado($codigoResultado ){
        $this-> $codigoResultado  =$codigoResultado;
    }

    public function getMensaje(){
        return $this->mensaje;
    }
    public function setMensaje($mensaje){
        $this->mensaje = $mensaje;
    }


    public function __toString(){
        return "IDPRODUCTO: " . $this->IDPRODUCTO . 
            " NOMBREPRODUCTO: " . $this->NOMBREPRODUCTO . 
            " CANTIDADDISPONIBLE: " . $this->CANTIDADDISPONIBLE . 
            " PRECIOCOSTO: " . $this->PRECIOCOSTO . 
            " IMPUESTO15: " . $this->IMPUESTO15 .
            " IMPUESTO18: " . $this->IMPUESTO18 .  
            " DESCUENTO: " . $this->DESCUENTO .
            " PRECIOVENTA: " . $this->PRECIOVENTA . 
            " ESTADO: " . $this->ESTADO . 
            " TIPOPRODUCTO_IDPRODUCTO: " . $this->TIPOPRODUCTO_IDPRODUCTO;

    }




    public function obtenerProductos($conexion){       

        $sql = " 
        select
        t2.idproducto,
        t2.nombreproducto,
        t2.cantidaddisponible,
        t2.preciocosto,
        t2.impuesto15,
        t2.impuesto18,
        t2.descuento,
        t2.precioventa,
        t2.estado,
        t2.tipoproducto_idtipoproducto,
        t3.tipoproducto,
        decode(t2.estado,'1','ACTIVO','INACTIVO')           
        from producto t2
        inner join tipoproducto t3 on t2.tipoproducto_idtipoproducto = t3.idtipoproducto
        order by  idproducto desc
         ";
        $query = oci_parse( $conexion->getConexion(),$sql);
	    oci_execute($query);         
            while (($row = oci_fetch_row($query)) != false) {
                    
                    echo  '
                    <tr>
                        <td>' .$row[0]. '</td>
                        <td>' .$row[1]. '</td>
                        <td>' .$row[2]. '</td>
                        <td>' .$row[3]. '</td>
                        <td>' .$row[4]. '</td>
                        <td>' .$row[5]. '</td>
                        <td>' .$row[6]. '</td>
                        <td>' .$row[7]. '</td>
                        <td>' .$row[10]. '</td>
                        <td>' .$row[11].  '</td>                        
                        <td>
                            <button class="modal-trigger waves-light  waves-effect" 
                                    style="background-color:lightseagreen;"
                                    data-target="modal-producto-editarDatos" 
                                    onclick="abrirModal_productoEditarDatos ('.$row[0].')">Editar</button>
                        </td>
                        <td>
                        <div><button class="modal-trigger waves-light  waves-effect"
                            style="background-color:indianred;" 
                            data-target="modal-producto-eliminar"   
                            onclick="abrirModal_productoEliminar ('.$row[0].')">Eliminar</button>
                        </div>
                        </td>
                    </tr>';
         }        

         oci_free_statement($query);
         $conexion->cerrarConexion(); 
    }

    
    public function obtenerProducto($conexion,$ID){       

        $sql = " 
        select  
                t2.idproducto,
                t2.nombreproducto,
                t2.cantidaddisponible,
                t2.preciocosto,
                t2.impuesto15,
                t2.impuesto18,
                t2.descuento,
                t2.precioventa,
                t2.estado,
                t2.tipoproducto_idtipoproducto,
                t3.tipoproducto,
                decode(t2.estado,'1','ACTIVO','INACTIVO')     
            from producto t2
            inner join tipoproducto t3 on t2.tipoproducto_idtipoproducto = t3.idtipoproducto
        where t2.idproducto = ".$ID."
         ";
        $query = oci_parse( $conexion->getConexion(),$sql);
        oci_execute($query); 
        

        while (($row = oci_fetch_row($query)) != false) {         
            $this->setIDPRODUCTO( $row[0]);          
            $this->setNOMBREPRODUCTO( $row[1]);  
            $this->setCANTIDADDISPONIBLE( $row[2]);  
            $this->setPRECIOCOSTO( $row[3]);  
            $this->setIMPUESTO15( $row[4]);  
            $this->setIMPUESTO18( $row[5]);  
            $this->setDESCUENTO( $row[6]);  
            $this->setPRECIOVENTA( $row[7]);  
            $this->setESTADO( $row[8]);  
            $this->setTIPOPRODUCTO_IDPRODUCTO( $row[9]);  

           };   
         oci_free_statement($query);
         $conexion->cerrarConexion(); 
    }

    public function obtenerTipoProducto($conexion){
        $sql = "Select t1.idtipoproducto,
                t1.tipoproducto 
                from tipoproducto t1 ";

                $query = oci_parse($conexion->getConexion(),$sql);
                oci_execute($query);
                while (($row = oci_fetch_row($query)) != false) {         
                  echo  '<option value="'.$row[0].'">'. $row[1].'</option>';          
                 };             
                 oci_free_statement($query );
                 $conexion->cerrarConexion(); 

   }

    public function guardarProducto($conexion){
        $sql = sprintf(
                "DECLARE
                PCNOMBREPRODUCTO VARCHAR2(200);
                PNCANTIDADDISPONIBLE NUMBER;
                PNIDTIPOPRODUCTO NUMBER;
                PNPRECIOCOSTO FLOAT;
                PNIMPUESTO15 FLOAT;
                PNIMPUESTO18 FLOAT;
                PNDESCUENTO FLOAT;
                PNPRECIOVENTA FLOAT;
                PNESTADO FLOAT;
                PNCODIGO NUMBER;
                PCMENSAJE VARCHAR2(200);
              BEGIN
                PCNOMBREPRODUCTO := '".$this->NOMBREPRODUCTO."';
                PNCANTIDADDISPONIBLE := ".$this->CANTIDADDISPONIBLE.";
                PNIDTIPOPRODUCTO := ".$this->TIPOPRODUCTO_IDPRODUCTO.";
                PNPRECIOCOSTO := ".$this->PRECIOCOSTO.";
                PNIMPUESTO15 := ".$this->IMPUESTO15.";
                PNIMPUESTO18 := ".$this->IMPUESTO18.";
                PNDESCUENTO := ".$this->DESCUENTO.";
                PNPRECIOVENTA := ".$this->PRECIOVENTA.";
                PNESTADO := ".$this->ESTADO.";
              
                SP_REGISTRARPRODUCTO(
                  PCNOMBREPRODUCTO => PCNOMBREPRODUCTO,
                  PNCANTIDADDISPONIBLE => PNCANTIDADDISPONIBLE,
                  PNIDTIPOPRODUCTO => PNIDTIPOPRODUCTO,
                  PNPRECIOCOSTO => PNPRECIOCOSTO,
                  PNIMPUESTO15 => PNIMPUESTO15,
                  PNIMPUESTO18 => PNIMPUESTO18,
                  PNDESCUENTO => PNDESCUENTO,
                  PNPRECIOVENTA => PNPRECIOVENTA,
                  PNESTADO => PNESTADO,
                  PNCODIGO => PNCODIGO,
                  PCMENSAJE => PCMENSAJE
                );
               
              END;
                ");
            
        $conexion->ejecutarConsulta($sql);
        $conexion->cerrarConexion(); 
        $this->mensaje='Producto guardado con exito.' ;
        $this->codigoResultado=1 ;
    }


    public function editarProducto($conexion){
        $sql = sprintf(
            "DECLARE
                PNIDPRODUCTO NUMBER;
                PNESTADO NUMBER;
                PNCANTIDAD NUMBER;
                PNPRECIOCOSTO FLOAT;
                PNDESCUENTO FLOAT;
                PNIMPUESTO15 FLOAT;
                PNIMPUESTO18 FLOAT;
                PNCODIGO NUMBER;
                PCMENSAJE VARCHAR2(200);
              BEGIN
                PNIDPRODUCTO := ".$this->IDPRODUCTO.";
                PNESTADO := ".$this->ESTADO.";
                PNCANTIDAD := ".$this->CANTIDADDISPONIBLE.";
                PNPRECIOCOSTO := ".$this->PRECIOCOSTO.";
                PNDESCUENTO := ".$this->DESCUENTO.";
                PNIMPUESTO15 :=  ".$this->IMPUESTO15.";
                PNIMPUESTO18 := ".$this->IMPUESTO18.";
              
                SP_EDITARPRODUCTO(
                  PNIDPRODUCTO => PNIDPRODUCTO,
                  PNESTADO => PNESTADO,
                  PNCANTIDAD => PNCANTIDAD,
                  PNPRECIOCOSTO => PNPRECIOCOSTO,
                  PNDESCUENTO => PNDESCUENTO,
                  PNIMPUESTO15 => PNIMPUESTO15,
                  PNIMPUESTO18 => PNIMPUESTO18,
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
                $this->mensaje='Producto editado con exito.' ;
                 $this->codigoResultado=1 ;
            }
        $conexion->cerrarConexion(); 
       
    }

    public function eliminarProducto($conexion,$idProductoEliminar){
        $sql = sprintf(
                "delete from producto p where p.idproducto ='".$idProductoEliminar."'");            
        $query = oci_parse( $conexion->getConexion(),$sql);
        $result =  oci_execute($query); 
        oci_free_statement($query );        
        $conexion->cerrarConexion(); 
        $this->mensaje='Producto eliminado con exito.' ;
        $this->codigoResultado=1 ;
    }
}
?>