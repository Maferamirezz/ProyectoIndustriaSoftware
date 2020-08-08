<?php
	
	class Conexion{
		private $hostDB = "localhost/XE";
		private $usuarioDB = "GAMA";
		private $passDB = "legolas";
		private $link;

		public function __construct(){
			$this->link = oci_connect("GAMA","legolas","localhost/XE");
			if (!$this->link) {
	    	$e = oci_error();
	    	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	       }
		}
	

	public function ejecutarConsulta($sql){
			$query = oci_parse($this->link,$sql);
			 oci_execute($query);
            return $query;
		}


		public function obtenerFila($resultado){
			return oci_fetch_array($resultado,OCI_BOTH);
		}


		 public function cerrarConexion(){
			oci_close($this->link);
		}


		public function antiInyeccion($texto){
		//[INDENT] return str_replace("'", "\'", $texto); [/INDENT] 

		}

		public function cantidadRegistros($resultado){
			return oci_num_rows($resultado);
			
		}

    }
?>