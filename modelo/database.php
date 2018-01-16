<?php 
class Database{
	// Propiedades
	private $conexion;
	private $db_host = "localhost";
	private $db_user = "root";
	private $db_passwd = "root";
	private $db_name = "virtualmarket";
	// MÉTODOS MÁGICOS
	// Constructor de la clase
	function __construct(){
		$this->conectar();
	}
	// Método __get
	public function __get($propiedad){
		if (property_exists(__CLASS__, $propiedad)){
			return $this->$propiedad;
		}else {
			return false;
		}
	}

	// Método para conectar
	private function conectar(){
		$this->conexion = new mysqli($this->db_host, $this->db_user, $this->db_passwd, $this->db_name);
		if ($this->conexion->connect_errno) {
			echo "Fallo al conectar a MYSQL: " . $conexion->connect_error;
		}
		return $this->conexion;
	}
	// Método desconectar
	public function desconectar(){
		$this->conexion->close();
	}
}
?>