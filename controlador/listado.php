<?php 
$this->vista->mostrarContenidoListado($this->colaMensajes);


// DEBUG: tests modelo
// - listar
//$misClientes = Cliente::obtenerClientes($this->database);
//print_r($misClientes);
// - obtener
//$ig = Cliente::obtenerCliente($this->database, '48404267P');
//echo "$ig->dni $ig->nombre $ig->direccion $ig->email $ig->password";
// - insertar
//$miCliente = new Cliente('68606267P', 'Paco Sanz', 'C/La piruleta 6', 'donaciones@hotmail.com', '123456');
//echo $miCliente->insertarCliente($this->database);
// - modificar
//$miCliente = new Cliente('68606267P', 'Paco Sanz', 'C/La piruleta 6', 'donaciones@hotmail.com', '654321');
//$miCliente->modificarCliente($this->database);
// - eliminar
//$miCliente = new Cliente('68606267P');
//$miCliente->eliminarCliente($this->database);

?>