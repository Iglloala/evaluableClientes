PRÁCTICA USANDO OBJETOS Y EL MODELO VISTA CONTROLADOR.

Haremos un mantenimiento de la tabla de clientes de virtualmarket usando clases e intentando respetar al máximo el modelo vista controlador.

La estructura del trabajo, será:
MODELO. Será un fichero con la definición de todas las clases
VISTA. Será un archivo con funciones que contienen todas las instrucciones HTML para mostrar el contenido en cada momento de la web.
CONTROLADOR. Estará formado por todos aquellos ficheros php que a base de usar el  MODELO  y llamadas a funciones de la VISTA realizarán las tareas necesarias. También habrá, si es necesario un fichero de funciones que no tengan que ver con la vista.


MODELO
Todos las clases tendrán el constructor y los métodos mágicos de get y set.
Como mínimo tendremos las siguientes clases:
Conexión: Con una sola propiedad que será el resultado de la conexión y el método constructor, para establecer la conexión con la base de datos y dar valor a esta propiedad. En el constructor se debe de comprobar, antes de realizar la conexión si esta ya está establecida para no volver a crearla.
Cliente: Tendrá al memos una propiedad por cada campo y todos los métodos necesarios para realizar el mantenimiento final sobre la base de datos. (ojo sin nada de html). La elección de los parámetros es libre pero, si se necesita el enlace a la base de datos este se pasará siempre como parámetros si es necesario algún valor de un campo que se cogerán de sus propiedades. Ojo el listado de los clientes no es un método de esta clase porque implica a más de una instancia de este objeto.

La web tendrá un encabezado y un pie que se repetirá en todas las páginas.
En el encabezado habrá un menú con las siguientes opciones:
NOTA: Siempre que se pida un DNI hay que escaparlo tambien.
Listado: Mostrará un listado de todos los clientes
Alta: Formulario para introducir clientes, comprobando que no existen antes y escapando todos los campos introducidos para evitar inyecciones de código.
Baja: Se introduce el dni y se busca, si existe se muestra y se le da a un botón para borrar.
Modificaciones: Se pide el dni y si está se muestra en un formulario y se modifican todos los campos con lo que se introduzca en este. Hay que escapar todos los campos.
Consulta: Se introduce el dni y se muestran todos sus datos.
El pie solo tendrá un mensaje que indicará en que parte de la web te encuentras.