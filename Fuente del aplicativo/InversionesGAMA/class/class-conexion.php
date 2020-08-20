<?php
	
	class Conexion{

		private $link;

		public function getConexion(){
			return $this->link;
		}
		public function setConexion($link){
			$this->link = $link;
		}

		public function __construct(){
			$hostDB = "localhost/orcl";
			$usuarioDB = "system"; 
			$passDB = "oracle";
			$this->link = oci_connect($usuarioDB, $passDB,  $hostDB) or die('Connection failed!');
			if (!$this->link) {
	    	$e = oci_error();
	    	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	       }			
		}

		public function conexion(){
			$hostDB = "localhost/orcl";
			$usuarioDB = "system"; 
			$passDB = "oracle";
			$this->link = oci_connect($usuarioDB, $passDB,  $hostDB) or die('Connection failed!');
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