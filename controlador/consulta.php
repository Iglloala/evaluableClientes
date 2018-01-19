<?php 
	// Si no se seleccionado ya un cliente pues carga el formulario de búsqueda por dni
	// Si  NO se ha enviado un dni para modificar entonces muestra el formulario para solicitar un DNI
	if (!isset($_POST['btSeleccionarCliente'])){
		array_push($this->colaMensajes, ['tipo'=>'info', 'texto'=>"Introduce el DNI del cliente que quieras consultar"]);
		$this->vista->mostrarContenidoConsulta($this->colaMensajes, "seleccion");
	}
	// Ahora bien si ya se ha enviado un DNI pues comprobamos que exista
	elseif (isset($_POST['btSeleccionarCliente'])){
		// preparo el campo
		$dniCliente = $this->obtenerPost('dniCliente');
		// compruebo que exista
		if ($cliente = Cliente::obtenerCliente($this->database, $dniCliente)){
			// Y si es así preparo el resto de campos y llamo a la vista pasándole un array con datosCliente para rellenar la tabla
			$dniCliente = $cliente->dniCliente;
			$nombre = $cliente->nombre;
			$direccion = $cliente->direccion;
			$email = $cliente->email;
			$pwd = $cliente->pwd;
			$datosCliente = ["dniCliente"=>$dniCliente, "nombre"=>$nombre, "direccion"=>$direccion, "email"=>$email, "pwd"=>$pwd];
			$this->vista->mostrarContenidoConsulta($this->colaMensajes, "consulta", $datosCliente);
		}
		// Ahora, si no existe pues llamo a la vista pasándole un mensaje de error y el dni que se ha pasado anteriormente
		else {
			array_push($this->colaMensajes, ['tipo'=>'danger', 'texto'=>"No existe ningún usuario con DNI: <b>$dniCliente</b>"]);
			// Haz cosas
			$this->vista->mostrarContenidoConsulta($this->colaMensajes, "seleccion");
		}
	}
?>