<?php

class Insumo{

    private $NOMBREINSUMO;
    private $FECHACOMPRA;
    private $CANTIDAD;
    private $PRECIO;
    private $TIPOINSUMO_IDTIPOINSUMO;
    private $USUARIO_IDUSUARIO;
    private $PROVEEDOR_RTNPROVEEDOR;
    private $codigoResultado;
    private $mensaje;
    private $listaInsumos;
    
    public function __construct(
                $NOMBREINSUMO,
                $FECHACOMPRA,
                $CANTIDAD,
                $PRECIO,
                $TIPOINSUMO_IDTIPOINSUMO,
                $USUARIO_IDUSUARIO,
                $PROVEEDOR_RTNPROVEEDOR
                ){
        $this->NOMBREINSUMO = $NOMBREINSUMO;
        $this->FECHACOMPRA = $FECHACOMPRA;
        $this->CANTIDAD = $CANTIDAD;
        $this->PRECIO = $PRECIO;
        $this->TIPOINSUMO_IDTIPOINSUMO = $TIPOINSUMO_IDTIPOINSUMO;
        $this->USUARIO_IDUSUARIO = $USUARIO_IDUSUARIO;
        $this->PROVEEDOR_RTNPROVEEDOR = $PROVEEDOR_RTNPROVEEDOR;
       
    }
    public function __construct0()
	{
	
    }
    
    static function soloObjectoInsumo()
	{
		return new self('n' ,
        'n',
        'n',
        'n',
        'n',
        'n',
        'n');
    } 
   
    public function getNOMBREINSUMO(){
        return $this->NOMBREINSUMO;
    }
    public function setNOMBREINSUMO($NOMBREINSUMO){
        $this->NOMBREINSUMO = $NOMBREINSUMO;
    }
    public function getFECHACOMPRA(){
        return $this->FECHACOMPRA;
    }
    public function setFECHACOMPRA($hFECHACOMPRA){
        $this->FECHACOMPRA = $FECHACOMPRA;
    }
    public function getCANTIDAD(){
        return $this->CANTIDAD;
    }
    public function setCANTIDAD($CANTIDAD){
        $this->CANTIDAD = $CANTIDAD;
    }

    public function getPRECIO(){
        return $this->PRECIO;
    }
    public function setPRECIO($PRECIO){
        $this->PRECIO = $PRECIO;
    }
    public function getTIPOINSUMO_IDTIPOINSUMO(){
        return $this->TIPOINSUMO_IDTIPOINSUMO;
    }
    public function setTIPOINSUMO_IDTIPOINSUMO($TIPOINSUMO_IDTIPOINSUMO){
        $this->TIPOINSUMO_IDTIPOINSUMO = $TIPOINSUMO_IDTIPOINSUMO;
    }
    public function getUSUARIO_IDUSUARIO(){
        return $this->USUARIO_IDUSUARIO;
    }
    public function setUSUARIO($USUARIO_IDUSUARIO){
        $this->USUARIO_IDUSUARIO = $USUARIO_IDUSUARIO;
    }
    public function getPROVEEDOR_RTNPROVEEDOR(){
        return $this->PROVEEDOR_RTNPROVEEDOR;
    }
    public function setPROVEEDOR_RTNPROVEEDOR($PROVEEDOR_RTNPROVEEDOR){
        $this->PROVEEDOR_RTNPROVEEDOR = $PROVEEDOR_RTNPROVEEDOR;
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

    public function getlistaInsumos(){
        return $this->listaInsumos;
    }
    public function setlistaInsumos($listaInsumos){
        $this->listaInsumos = $listaInsumos;
    }
    public function __toString(){
        return  
            " NOMBREINSUMO: " . $this->NOMBREINSUMO . 
            " FECHACOMPRA: ".$this->FECHACOMPRA. 
            " CANTIDAD: " . $this->CANTIDAD . 
            " TIPOINSUMO_IDTIPOINSUMO: " . $this->TIPOINSUMO_IDTIPOINSUMO . 
            " PRECIO: " . $this->PRECIO . 
            " USUARIO_IDUSUARIO: " . $this->USUARIO_IDUSUARIO . 
            " PROVEEDOR_RTNPROVEEDOR: " . $this->PROVEEDOR_RTNPROVEEDOR;
    }

      public  function obtenerInsumos($conexion){
     
        $sql = " 
        select 
         t1.idinsumo,
         t1.nombreinsumo,
         t1.precio,
         t1.cantidad,
         t1.fechacompra,
        (SELECT t2.nombreproveedor FROM proveedor  T2 WHERE t2.rtnproveedor = t1.proveedor_rtnproveedor ),
        (SELECT t3.tipoinsumo FROM tipoinsumo  T3 WHERE t3.idtipoinsumo = t1.tipoinsumo_idtipoinsumo ),
        (SELECT t4.username FROM usuario T4 WHERE T4.idusuario  = t1.usuario_idusuario )
        from insumo t1 order by t1.idinsumo desc
         ";
        $query = oci_parse( $conexion->getConexion(),$sql);
	    oci_execute($query);         
            while (($row = oci_fetch_row($query)) != false) {
                echo   ' <li class="collection-item avatar flex-div scroll-item grid-display">
                    <div>
                        <div class="col s12 m6" style="font-weight: bold;" id="inv-producto-insumo'.$row[0].'"> '.$row[1].'</div>
                        <div class="col s12 m6" style="font-family: monospace;" id="inv-fecha-insumo'.$row[0].'">'. $row[4].'</div> 
                        <div class="grey-text col s12 m6">Cantidad: <span id="inv-cantidad-insumo'.$row[0].'" class="bold-text>'. $row[3].'</span></div>
                        <div class="grey-text col s12 m6">Precio: <span id="inv-precio-insumo$'.$row[0].'" class="black-text">'.$row[2].'</span></div>
                        <div class="grey-text col s12">Proveedor: <span class="black-text" id="inv-proveedor-insumo'.$row[0].'"> '.$row[5].'</span></div>
                        <div class="grey-text col s12">Tipo: <span class="black-text" id="inv-tipo-insumo'.$row[0].'">'.$row[6].'</span></div>
                        <div class="grey-text col s12">Registrado por: <span class="black-text" id="inv-nombreEmpleado-insumo'.$row[0].'">'.$row[7].'</span></div>
                        <div class="col s12">
                        <button class="modal-trigger link-style" onclick="abrirModal_insumoEditar('.$row[0].')">Editar</button>
                        </div>
                    </div>
                    </li>
                    ';             
         }        

         oci_free_statement($query);
         $conexion->cerrarConexion(); 
    }

    
    public  function obtenerTipoInsumo($conexion){        
            $sql = "Select t1.idtipoinsumo,
                             t1.tipoinsumo 
                     from tipoinsumo t1 ";      
            $query = oci_parse($conexion->getConexion(),$sql);
            oci_execute($query);
            while (($row = oci_fetch_row($query)) != false) {            
              echo  '<option value="'.$row[0].'">'. $row[1].'</option>';          
             };             
             oci_free_statement($query );
             $conexion->cerrarConexion(); 
    }

    public  function obtenerProveedores($conexion){        
        $sql = 'SELECT  t1.rtnproveedor, 
                        t1.nombreproveedor 
                 FROM proveedor t1 ';      
        $query = oci_parse($conexion->getConexion(),$sql);
        oci_execute($query);
        while (($row = oci_fetch_row($query)) != false) {            
          echo  '<option value="'.$row[0].'">'. $row[1].'</option>';          
         };             
         oci_free_statement($query );
         $conexion->cerrarConexion(); 
    }
   

    public function guardarInsumo($conexion){
        $sql = sprintf(
                "DECLARE
                PCUSERNAME VARCHAR2(200);
                PCNOMBREINSUMO VARCHAR2(200);
                PDFECHACOMPRA DATE;
                PNRTNPROVEEDOR VARCHAR2(200);
                PNIDTIPOINSUMO NUMBER;
                PNCANTIDAD NUMBER;
                PNPRECIO NUMBER;
                PNCODIGO NUMBER;
                PCMENSAJE VARCHAR2(200);
                BEGIN
                PCUSERNAME := '".$this->USUARIO_IDUSUARIO."';
                PCNOMBREINSUMO := '".$this->NOMBREINSUMO."';
                PDFECHACOMPRA := to_date('".$this->FECHACOMPRA."','yyyy-MM-dd');
                PNRTNPROVEEDOR := '".$this->PROVEEDOR_RTNPROVEEDOR."';
                PNIDTIPOINSUMO := ".$this->TIPOINSUMO_IDTIPOINSUMO.";
                PNCANTIDAD := ".$this->CANTIDAD.";
                PNPRECIO := ".$this->PRECIO.";

                SP_REGISTRARINSUMO(
                PCUSERNAME => PCUSERNAME,
                PCNOMBREINSUMO => PCNOMBREINSUMO,
                PDFECHACOMPRA => PDFECHACOMPRA,
                PNRTNPROVEEDOR => PNRTNPROVEEDOR,
                PNIDTIPOINSUMO => PNIDTIPOINSUMO,
                PNCANTIDAD => PNCANTIDAD,
                PNPRECIO => PNPRECIO,
                PNCODIGO => PNCODIGO,
                PCMENSAJE => PCMENSAJE
                );
                END;
                ");
            
        $conexion->ejecutarConsulta($sql);
        $this->mensaje='Insumo Registro guardado con exito.' ;
        $this->codigoResultado=1 ;
    }

    public function guardarInsumo1($conexion){             
        $CODIGO =0;
        $MENSAJE = 'ESTO NO SIRVE' ;
            $query= 'Begin 
                 SP_REGISTRARINSUMO(
                 :PCUSERNAME,    
                 :PCNOMBREINSUMO,
                 :PDFECHACOMPRA,
                 :PNRTNPROVEEDOR,
                 :PNIDTIPOINSUMO,
                 :PNCANTIDAD,
                 :PNPRECIO,
                 :PNCODIGO,
                 :PCMENSAJE
             );
             end;';
             $stid = oci_parse($conexion->getConexion(),$query);             
              oci_bind_by_name($stid, ':PCUSERNAME', $this->USUARIO_IDUSUARIO);
              oci_bind_by_name($stid, ':PCNOMBREINSUMO', $this->NOMBREINSUMO);
              oci_bind_by_name($stid, ':PDFECHACOMPRA', $this->FECHACOMPRA);
              oci_bind_by_name($stid, ':PNRTNPROVEEDOR', $this->PROVEEDOR_RTNPROVEEDOR);
              oci_bind_by_name($stid, ':PNIDTIPOINSUMO', $this->TIPOINSUMO_IDTIPOINSUMO);
              oci_bind_by_name($stid, ':PNCANTIDAD', $this->CANTIDAD);
              oci_bind_by_name($stid, ':PNPRECIO', $this->PRECIO);
              oci_bind_by_name($stid, ':PNCODIGO', $CODIGO);
              oci_bind_by_name($stid, ':PCMENSAJE',$MENSAJE);            
           
         oci_execute($stid);
       
         print "$stid";   // prints 16
        oci_free_statement($query);
        $conexion->cerrarConexion(); 

        $this->mensaje=$MENSAJE ;
        $this->codigoResultado= $CODIGO;
    }
}
?>