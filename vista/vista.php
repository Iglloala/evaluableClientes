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
	
	// Defino un método que mostrará el footer modificando el template footer.tpl y añadiéndole el breadcrumb generado según la página que se vaya a visualizar en ese momento
	public function cargarFooter(string $pagina){
		$template = file_get_contents('vista/footer.tpl');
		// Construyo el breadcrumb
		$nombrePagina = ucfirst($pagina);
		$html = ($pagina == 'portada') ? "<li class='breadcrumb-item active' aria-current='page'><a href='?p=$pagina'>$nombrePagina</a></li>" : "<li class='breadcrumb-item'><a href='?p=$portada'>Portada</a></li><li class='breadcrumb-item active' aria-current='page'><a href='?p=$pagina'>$nombrePagina</a></li>";
		$template = str_replace("{BREADCRUMB}", $html, $template);
		// Y muestro el footer ya completo
		print $template;
	}

	// Defino una función utilitaria para cargar los mensajes en el template base.tpl en caso de haberlos
	private function cargarMensajes(array $colaMensajes){
		$template = file_get_contents('vista/base.tpl');
		$html ='';
		if (count($colaMensajes>0)){
			$html .= "<div class='wrapper-mensajes row'>";
			$html .= "  <div class='col-12'>";
			foreach ($colaMensajes as $mensaje) {
				// Por cada mensaje genero el código html para mostrarlo según el tipo que sea (success, danger o info)
				if ($mensaje['tipo'] == 'success'){
					$html .= "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
					$html .= $mensaje['texto'];
				}
				elseif ($mensaje['tipo'] == 'danger'){
					$html .= "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
					$html .= $mensaje['texto'];
				}
				else {
					$html .= "<div class='alert alert-info alert-dismissible fade show' role='alert'>";
					$html .= $mensaje['texto'];
				}
				// E inserto también los botones de cierre, y termino de cerrar etiquetas
				$html .= '  <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">';
				$html .= '    <span aria-hidden="true">&times;</span>';
				$html .= '  </button>';
				$html .= '</div>';
			}
			$html .= "  </div>";
			$html .= "</div>";
		}
		$template = str_replace("{MESSAGES}", $html, $template);
		return $template;
	}

	// Defino un método para cargar el contenido de la portada. Además si recibe una lista de mensajes de alerta y/o información tendrá que mostrarlos justo antes del contenido.
	public function mostrarContenidoPortada(array $colaMensajes = []){
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/portada.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		// Si tuviese contenido dinámico aquí iría reemplazando más {ETIQUETAS} por su contenido.
		// --
		// Y muestro el contenido ya completo
		print $html;
	}

	public function mostrarContenidoListado(array $colaMensajes = []){
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/listado.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		// Si tuviese contenido dinámico aquí iría reemplazando más {ETIQUETAS} por su contenido.
		// --
		// Y muestro el contenido ya completo
		print $html;
	}
}

?>