<?php
	// Si  NO se ha enviado un dni para modificar entonces muestra el formulario para solicitar un DNI
	if (!isset($_POST['btSeleccionarCliente'])){
		array_push($this->colaMensajes, ['tipo'=>'info', 'texto'=>"Introduce el DNI del cliente que quieras modificar"]);
		$this->vista->mostrarContenidoModificar($this->colaMensajes, "seleccion");
	}
	// Ahora bien si ya se ha enviado un DNI pues comprobamos que exista
	elseif (isset($_POST['btSeleccionarCliente'])){
		// preparo el campo
		$dniCliente = $this->obtenerPost('dniCliente');
		// compruebo que exista
		if ($cliente = Cliente::obtenerCliente($this->database, $dniCliente)){
			// Y si es así preparo el resto de campos y llamo a la vista pasándole un array con datosCliente para rellenar el formulario
			$dniCliente = $cliente->dniCliente;
			$nombre = $cliente->nombre;
			$direccion = $cliente->direccion;
			$email = $cliente->email;
			$pwd = $cliente->pwd;
			$datosCliente = ["dniCliente"=>$dniCliente, "nombre"=>$nombre, "direccion"=>$direccion, "email"=>$email, "pwd"=>$pwd];
			$this->vista->mostrarContenidoModificar($this->colaMensajes, "modificacion", $datosCliente);
		}
		// Ahora, si no existe pues llamo a la vista pasándole un mensaje de error y el dni que se ha pasado anteriormente
		else {
			array_push($this->colaMensajes, ['tipo'=>'danger', 'texto'=>"No existe ningún usuario con DNI: <b>$dniCliente</b>"]);
			// Haz cosas
			$this->vista->mostrarContenidoModificar($this->colaMensajes, "seleccion");
		}
	}
	//////////////////////////////////////////////////////////////
	// ESTO ES MIERDA
	//////////////////////////////////////////////////////////////
	// Si ya se han enviado ya los datos para actualizar pues convierto esos datos en una instancia de cliente y ejecuto el update
	if (isset($_POST['btRegistrarCliente'])){
		// preparo los datos
		$dniCliente = $this->obtenerPost('dniCliente');
		$nombre = $this->obtenerPost('nombre');
		$direccion = $this->obtenerPost('direccion');
		$email = $this->obtenerPost('email');
		$pwd = $this->obtenerPost('pwd');
		// Instancio un nuevo objeto cliente
		$nuevoCliente = new Cliente($dniCliente, $nombre, $direccion, $email, $pwd);
		// Lo almaceno en la bbdd
		if ($nuevoCliente->modificarCliente($this->database)){
			// Y si ha tenido éxito llamo a la vista pasándole un mensaje de confirmación
			array_push($this->colaMensajes, ["tipo"=>"success", "texto"=>"El cliente ha sido correctamente actualizado."]);
		}
		else {
			// Si no ha tenido éxito llamo a la vista pasándole un mensaje de error
			array_push($this->colaMensajes, ["tipo"=>"danger", "texto"=>"No se han podido actualizar los datos del cliente."]);
		}
		// Llamo a la vista pasándole la cola de mensajes
		$this->vista->mostrarContenidoModificar($this->colaMensajes, "seleccion");
	}
?>