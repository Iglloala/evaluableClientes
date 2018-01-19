<?php 
	// Si  NO se ha enviado un dni para eliminar ni tampoco el botón de confirmación de baja entonces muestra el formulario para solicitar un DNI
	if (!isset($_POST['btSeleccionarCliente']) && !isset($_POST["btConfirmarBaja"])){
		array_push($this->colaMensajes, ['tipo'=>'info', 'texto'=>"Introduce el DNI del cliente que quieras eliminar"]);
		$this->vista->mostrarContenidoBaja($this->colaMensajes, "seleccion");
	}
	// Ahora bien si ya se ha enviado un DNI pues comprobamos que exista
	elseif (isset($_POST['btSeleccionarCliente']) && !isset($_POST['btConfirmarBaja'])){
		// preparo el campo
		$dniCliente = $this->obtenerPost('dniCliente');
		// compruebo que exista
		if (Cliente::obtenerCliente($this->database, $dniCliente)){
			// Y si es así pues llamo a la vista mostrando el formulario de confirmación
			$this->vista->mostrarContenidoBaja($this->colaMensajes, "confirmacion", $dniCliente);
		}
		// Ahora, si no existe pues llamo a la vista pasándole un mensaje de error y el dni del cliente en cuestión
		else {
			array_push($this->colaMensajes, ['tipo'=>'danger', 'texto'=>"No existe ningún usuario con DNI: <b>$dniCliente</b>"]);
			$this->vista->mostrarContenidoBaja($this->colaMensajes, "seleccion", $dniCliente);
		}
	}
	// Y si llega por post btConfirmarBaja pues ya lo elimina y llama a la vista pasándole un mensaje de confirmación
	elseif (isset($_POST['btConfirmarBaja'])){
		// Obtengo el campo oculto que lleva el dniCliente
		$dniCliente = $this->obtenerPost("dniCliente");
		// Obtengo una instancia del cliente con dicho dniCliente
		$cliente = Cliente::obtenerCliente($this->database, $dniCliente);
		// Lo trato de eliminar
		if ($cliente->eliminarCliente($this->database)){
			// Si se ha eliminado llamo a la vista con el mensaje de confirmación
			array_push($this->colaMensajes, ['tipo'=>'success', 'texto'=>"El usuario con dni <b>$dniCliente</b> se ha eliminado correctamente."]);
			$this->vista->mostrarContenidoBaja($this->colaMensajes, "seleccion", $dniCliente);
		}
		else {
			// Si no se ha eliminado llamo a la vista con un mensaje de error
			array_push($this->colaMensajes, ['tipo'=>'danger', 'texto'=>"No ha sido posible eliminar el usuario con dni <b>$dniCliente</b>."]);
			$this->vista->mostrarContenidoBaja($this->colaMensajes, "seleccion", $dniCliente);
		}
	}
?>