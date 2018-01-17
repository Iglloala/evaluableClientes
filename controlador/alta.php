<?php 
// Si no vienen por POST los datos para dar de alta un cliente nuevo
// genero una instancia vacía de cliente y se la paso a la vista para que renderice un formulario de alta
if (!$_POST['datosCliente']){
	$this->vista->mostrarContenidoAlta();
}
?>