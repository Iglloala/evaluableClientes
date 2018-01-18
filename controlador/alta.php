<?php 
// Si no vienen por POST los datos para dar de alta un cliente nuevo
// genero una instancia vacía de cliente y se la paso a la vista para que renderize un formulario de alta
if (!$_POST['btRegistrarCliente']){
	$this->vista->mostrarContenidoAlta();
}
// Si por el contrario sí que llega la petición con los datos de un nuevo cliente, lo que tiene que hacer es insertarlo en la bbdd e indicarle a la vista que tiene que sacar un mensaje de confirmación
else  {
	// preparo los datos
	$dniCliente = $this->obtenerPost('dniCliente');
	$nombre = $this->obtenerPost('nombre');
	$direccion = $this->obtenerPost('direccion');
	$email = $this->obtenerPost('email');
	$pwd = $this->obtenerPost('pwd');
	// Instancio un nuevo objeto cliente
	$nuevoCliente = new Cliente($dniCliente, $nombre, $direccion, $email, $pwd);
	// Lo almaceno en la bbdd
	if ($nuevoCliente->insertarCliente($this->database)){
		// Y si ha tenido éxito llamo a la vista pasándole un mensaje de confirmación
		array_push($this->colaMensajes, ["tipo"=>"success", "texto"=>"El nuevo cliente ha sido registrado correctamente."]);
	}
	else {
		// Si no ha tenido éxito llamo a la vista pasándole un mensaje de error
		array_push($this->colaMensajes, ["tipo"=>"danger", "texto"=>"El nuevo cliente no ha podido ser registrado correctamente"]);
	}
	// Llamo a la vista pasándole la cola de mensajes
	$this->vista->mostrarContenidoAlta($this->colaMensajes);
}
?>