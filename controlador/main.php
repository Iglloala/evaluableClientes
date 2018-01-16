<?php 
require_once('modelo/database.php');
require_once('modelo/cliente.php');
require_once('vista/vista.php');

class Controlador{
	// Propiedades
	private $database;
	private $vista;
	private $menuItems;
	// Constructor	
	function __construct(){
		// Inicializo los componentes de la aplicación
		$this->database = new Database();
		$this->vista = new Vista();
		$this->menuItems = ['Portada', 'Listado', 'Alta', 'Baja', 'Modificar', 'Consulta'];
		$this->colaMensajes = [];
	}
	
	// Métodos
	public function run(){
		// BLOQUE DE EJECUCIÓN PPAL
		
		// Defino la página que se está solicitando
		$pagina = (isset($_GET['p']) && $_GET['p']!="") ? $this->database->conexion->real_escape_string($_GET['p']) : 'portada';
		// Me aseguro que la página que voy a procesar sea de las mías
		if (!in_array(ucfirst($pagina), $this->menuItems)) {
			$pagina = 'portada';
		}
		// Determino la posición de la página solicitada dentro del array menuItems
		$numPagina = array_search(ucfirst($pagina), $this->menuItems);

		// Carga la cabecera
		$this->vista->cargarHeader($this->menuItems, $numPagina);
		$this->colaMensajes = [];

		// Debug:
		// $masMensajes = [["texto"=>'Te voy a cagar en el pecho', "tipo"=>'success'],
		// 				["texto"=>'Te voy a cagar en el pecho', "tipo"=>'danger'],
		// 				["texto"=>'Te voy a cagar en el pecho', "tipo"=>'info']];

		// Por cada página ejecuto una u otra orden
		switch ($pagina){
			case 'portada':
				require_once('controlador/portada.php');
				break;
			case 'listado':
				require_once('controlador/listado.php');
				break;
			case 'alta':
				//$pagina = 'alta';
				break;
			case 'baja':
				//$pagina = 'baja';
				break;
			case 'modificar':
				//$pagina = 'modificar';
				break;
			default:
				//$pagina = 'portada';
		}
		// Limpia la cola de mensajes una vez ya s ehan enviado a la vista
		$this->colaMensajes = [];

		// Carga  el footer
		$this->vista->cargarFooter($pagina);
	}
}
?>