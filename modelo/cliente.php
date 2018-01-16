<?php

class Cliente{
	// Propiedades
	private $dni;
	private $nombre;
	private $direccion;
	private $email;
	private $password;

	// Constructor
	function __construct(string $dniCliente, string $nombre="", string $direccion="", string $email="", string $pwd=""){
		$this->dniCliente = $dniCliente;
		$this->pwd = $pwd;
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->email = $email;
	}

	// Método __get
	public function __get($propiedad){
		if (property_exists(__CLASS__, $propiedad)){
			return $this->$propiedad;
		}else {
			return false;
		}
	}

	// obtenerClientes (List)
	public static function obtenerClientes(Database $database){
		$sql = "SELECT * FROM clientes";
		$resultado = $database->conexion->query($sql);
		$arrayClientes=[];
		while ($fila = mysqli_fetch_assoc($resultado)){
			$cliente = new Cliente($fila['dniCliente'], $fila['nombre'], $fila['direccion'], $fila['email'], $fila['pwd']);
			array_push($arrayClientes, $cliente);
		}
		return $arrayClientes;
	}

	// insertarCliente (Create)
	public function insertarCliente(Database $database){
		// Preparo los campos
		$dniCliente = $this->dniCliente;
		$nombre = $this->nombre;
		$direccion = $this->direccion;
		$email = $this->email;
		$pwd = $this->pwd;
		// Preparo la sentencia de inserción
		$sql = "INSERT INTO clientes (dniCliente, nombre, direccion, email, pwd) VALUES ('$dniCliente', '$nombre', '$direccion', '$email', '$pwd')";
		// Ejecuto la consulta
		if ($database->conexion->query($sql)){
			return true;
		}
		else { return false;}
	}

	// obtenerCliente (Read)
	public static function obtenerCliente(Database $database, string $dni){
		if ($dni!=""){
			$sql = "SELECT * FROM clientes WHERE dniCliente='$dni'";
			$resultado = $database->conexion->query($sql);
			if ($resultado) {
				while ($fila = mysqli_fetch_assoc($resultado)){
					$cliente = new Cliente($fila['dniCliente'], $fila['nombre'], $fila['direccion'], $fila['email'], $fila['pwd']);
				}
				return $cliente;
			}
		}
	}

	// modificarCliente (Update)
	// Esto se invoca desde un cliente ya establecido y usando su dni como clave permite modificar el resto de campos
	public function modificarCliente(Database $database){
		// Preparo los campos
		$dniCliente = $this->dniCliente;
		$nombre = $this->nombre;
		$direccion = $this->direccion;
		$email = $this->email;
		$pwd = $this->pwd;
		// Preparo la sentencia de actualización
		$sql = "UPDATE clientes SET  dniCliente='$dniCliente', nombre='$nombre', direccion='$direccion', email='$email', pwd='$pwd' WHERE dniCliente='$dniCliente'";
		// Ejecuto la consulta
		if ($database->conexion->query($sql)){
			return true;
		}
		else {return false;}
	}

	// eliminarCliente (Delete)
	// Esto se invoca desde una instancia de cliente y trata de eliminar su registro de la bbdd
	public function eliminarCliente(Database $database){
		// Preparo el campo que me interesa
		$dniCliente = $this->dniCliente;
		// Preparo la sentencia de borrado
		$sql = "DELETE FROM clientes WHERE dniCliente='$dniCliente'";
		// Ejecuto la consulta
		if($database->conexion->query($sql)){
			return true;
		}
		else {return false;}
	}
}
?>