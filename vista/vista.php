<?php 
	
class Vista{
	// Métodos de la vista
	
	// Defino un método que mostrará el header modificando el template header.tpl y añadiéndole los enlaces que se le pasen por parámetro. En su defecto insertará un sólo enlace 'Portada' como parámetro por defecto. El parámetro 'activo' representa el item del array que aparecerá resaltado.
	public function cargarHeader(array $enlaces=['Portada'], int $activo=0){
		$template = file_get_contents('vista/header.tpl');
		// Inserto los enlaces
		$html = "";
		foreach ($enlaces as $clave => $valor) {
			$get_param = strtolower($valor);
			$html .= ($activo == $clave) ? "<li class='nav-item active'>" : "<li class='nav-item'>";
			$html .= ($activo == $clave) ? "<a class='nav-link' href='?p=$get_param'>$valor <span class='sr-only'>(current)</span></a>" : "<a class='nav-link' href='?p=$get_param'>$valor</a>";
			$html .= "</li>";
		}
		$template = str_replace("{ITEMS_MENU}", $html, $template);
		// Y muestro la cabecera ya completa
		print $template;
	}
	
	public function cargarFooter(string $pagina){
		$template = file_get_contents('vista/footer.tpl');
		// Construyo el breadcrumb
		$nombrePagina = ucfirst($pagina);
		$html = ($pagina == 'portada') ? "<li class='breadcrumb-item active' aria-current='page'><a href='?p=$pagina'>$nombrePagina</a></li>" : "<li class='breadcrumb-item'><a href='?p=$portada'>Portada</a></li><li class='breadcrumb-item active' aria-current='page'><a href='?p=$pagina'>$nombrePagina</a></li>";
		$template = str_replace("{BREADCRUMB}", $html, $template);
		// Y muestro el footer ya completo
		print $template;
	}
}

?>