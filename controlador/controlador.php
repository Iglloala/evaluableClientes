<?php 
require_once('modelo/database.php');
require_once('modelo/cliente.php');
require_once('vista/vista.php');

class Controlador{
	// Propiedades
	private $conexion;
	private $vista;
	// Constructor	
	function __construct(){
		$this->conexion = new Database();
		$this->conexion->conectar();
		$this->vista = new Vista();
	}
	
	// Métodos
	public function run(){
		// BLOQUE DE EJECUCIÓN PPAL
		
		// Carga la cabecera
		$this->vista->cargarHeader();

		// Determina la página que tiene que procesar
		switch ($_GET['page']){
			case 'index':
				$pagina = 'index';
				break;
			case 'listado':
				$pagina = 'listado';
				break;
			case 'alta':
				$pagina = 'alta';
				break;
			case 'baja':
				$pagina = 'baja';
				break;
			case 'modificar':
				$pagina = 'modificar';
				break;
			default:
				$pagina = 'index';
		}
		// Carga  el footer
		$this->vista->cargarFooter();
	}
}
?>