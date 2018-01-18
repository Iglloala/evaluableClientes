<?php 
	
class Vista{
	// Métodos de la vista
	
	// Defino un método que mostrará el header modificando el template header.tpl y añadiéndole los enlaces que se le pasen por parámetro. En su defecto insertará un sólo enlace 'Portada' como parámetro por defecto. El parámetro 'activo' representa el item del array que aparecerá resaltado.
	public function cargarHeader($enlaces=['Portada'], $activo=0){
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
	public function cargarFooter($pagina){
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
	public function mostrarContenidoPortada($colaMensajes=[]){
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/portada.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		// Si tuviese contenido dinámico aquí iría reemplazando más {ETIQUETAS} por su contenido.
		// --
		// Y muestro el contenido ya completo
		print $html;
	}

	public function mostrarContenidoListado($colaMensajes=[], array $listadoClientes){
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/listado.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		// Ahora itero sobre los distintos clientes y voy generando sus filas para insertar en la tabla
		$tbody = "<tbody>";
		foreach ($listadoClientes as $numero => $cliente) {
			// preparo los campos
			$dniCliente = $cliente->dniCliente;
			$nombre = $cliente->nombre;
			// genero la fila
			$filaHtml = "<tr>";
			$filaHtml .= "  <th scope='row'>$numero</th>";
			$filaHtml .= "  <td>$dniCliente</td>";
			$filaHtml .= "  <td>$nombre</td>";
			$filaHtml .= "</tr>";
			// la inserto al tbody
			$tbody .= $filaHtml;
		}
		$tbody .= "</tbody>";
		// Reemplazo el token {FILAS} del template por el tbody ya completo
		$html = str_replace("{FILAS}", $tbody, $html);
		// Y muestro el contenido ya completo
		print $html;
	}

	// Defino una función a la que se le pasa tipoFormulario y dependiendo de si es para dar de alta o para actualizar devuelve un formulario apropiado. Si es para actualizar tiene que recibir por parámetro un array con las propiedades del cliente en cuestión.
	public function generaFormularioCliente($tipoFormulario, $datosCliente=[]){
		// Preparo los campos
		$dniCliente = $datosCliente['dniCliente'];
		$nombre = $datosCliente['nombre'];
		$direccion = $datosCliente['direccion'];
		$email = $datosCliente['email'];
		$pwd = $datosCliente['pwd'];
		// Empiezo a componer el formulario
		$html = "<form method='post' action=''>";
		// - dni
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='dniCliente'>DNI</label>";
		if ($tipoFormulario=="alta"){
			$html .= "    <input type='text' class='form-control' name='dniCliente' placeholder='DNI'>";
		}
		else {
			$html .= "    <input type='text' class='form-control' name='dniCliente' placeholder='DNI' value='$dniCliente' disabled>";
		}
		$html .= "  </div>";
		// - nombre
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='nombre'>Nombre</label>";
		$html .= "    <input type='text' class='form-control' name='nombre' placeholder='Nombre' value='$nombre'>";
		$html .= "  </div>";
		// - direccion
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='direccion'>Dirección</label>";
		$html .= "    <input type='text' class='form-control' name='direccion' placeholder='Dirección' value='$direccion'>";
		$html .= "  </div>";
		// - email
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='email'>Correo electrónico</label>";
		$html .= "    <input type='text' class='form-control' name='email' placeholder='Correo electrónico' value='$email'>";
		$html .= "  </div>";
		// - pwd
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='pwd'>Password</label>";
		$html .= "    <input type='password' class='form-control' name='pwd' placeholder='Password' value='$pwd'>";
		// - submit
		$html .= "      <button id='btRegistrarCliente' class='btn btn-primary btSubmit' type='submit' name='btRegistrarCliente' value='btRegistrarCliente'>Registrar cliente</button>";
		// eof: form
		$html .= "</form>";
		return $html;
	}

	public function mostrarContenidoAlta($colaMensajes=[]){
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/alta.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		// Ahora llamo a la función que genera el formulario e inserto su respuesta html en lugar del token {FORMULARIO} del template
		$formulario = $this->generaFormularioCliente("alta");
		$html = str_replace("{FORMULARIO}", $formulario, $html);
		// Y muestro el contenido ya completo
		print $html;
	}

	// Defino una función para generar un formulario en el que introducir un DNI
	public function generaFormularioSeleccionDNI(){
		$html = "<form method='post' action=''>";
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='dniCliente'>DNI</label>";
		$html .= "    <input type='text' class='form-control' name='dniCliente' placeholder='DNI'>";
		$html .= "    <button class='btn btn-primary btSubmit' type='submit' name='btSeleccionarCliente'>Buscar</button>";
		$html .= "  </div>";
		$html .= "</form>";
		return $html;
	}

	// Defino una función para generar un formulario para confirmar la acción de borrado
	public function generaFormularioConfirmacionBaja($dniCliente){
		$html = "<form method='post' action=''>";
		$html .= "  <div class='form-group'>";
		$html .= "    <label for='btConfirmarBaja'>Se va a eliminar el cliente con dni <b>$dniCliente</b>. Estás seguro?</label>";
		$html .= "</div>";
		$html .= "<div class='form-group'>";
		$html .= "    <button class='btn btn-primary btSubmit' type='submit' name='btConfirmarBaja'>Confirmar</button>";
		$html .= "  </div>";
		$html .= "</form>";
		return $html;
	}

	// Defino una función para mostrar el contenido de la pantalla de baja. Si se le pasa el argumento tipo="seleccion" entonces carga un formulario para insertar un dni. Si llega tipo="confirmacion", entonces muestra un botón para confirmar la acción
	public function mostrarContenidoBaja($colaMensajes, $tipo='seleccion', $dniCliente=''){
		if ($tipo == "seleccion"){
			// Genero el formulario para seleccionar un DNI
			$formulario = $this->generaFormularioSeleccionDNI();
		}
		elseif ($tipo == "confirmacion"){
			// Genero el formulario para seleccionar un DNI
			$formulario = $this->generaFormularioConfirmacionBaja($dniCliente);
		}
		// Y cargo el template junto con el formulario apropiado
		$base = $this->cargarMensajes($colaMensajes);
		$template = file_get_contents('vista/baja.tpl');
		$html = str_replace("{CONTENT}", $template, $base);
		$html = str_replace("{FORMULARIO}", $formulario, $html);
		// Y muestro el contenido ya completo
		print $html;
	}
}

?>