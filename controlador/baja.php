<?php 
	// Si  NO se ha enviado un dni para eliminar entonces muestra el formulario para solicitar un DNI
	if (!isset($_POST['btSeleccionarCliente'])){
		$this->vista->mostrarContenidoBaja($this->colaMensajes, "seleccion");
	}
	// Ahora bien si ya se ha enviado un DNI pues comprobamos que exista
	elseif (isset($_POST['btSeleccionarCliente'])){
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
?>