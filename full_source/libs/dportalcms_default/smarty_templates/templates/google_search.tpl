<script src="http://www.google.com/jsapi" type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[

google.load("search", "1.0");

function OnLoad() {

// :: Declare a Search control in tabbed mode

//Declare a new Custom Search control
var searchControl = new
google.search.CustomSearchControl
("003226150392065759631:sxb9vcz6utq");

// Opciones adicionales para los Resultados (global)
searchControl.setLinkTarget
(google.search.Search.LINK_TARGET_SELF);
searchControl.setResultSetSize
(google.search.Search.SMALL_RESULTSET);

// :: Dibujado y Ejecución del Control de búsqueda

// Declarar el Dibujado del Control y los Resultados

var drawOptions = new google.search.DrawOptions();

// Establecer las Opciones de dibujado (modo Tabbed)
drawOptions.setDrawMode
(google.search.SearchControl.DRAW_MODE_TABBED);

// Dibujar el Control de búsqueda (Formulario)
drawOptions.setSearchFormRoot(document.getElementById
("search_control_tabbed"));

// Dibujar los Resultados de la búsqueda
// independientemente del Control, si deseamos
// colocarlo en otra parte de la página
searchControl.draw(document.getElementById
("searchResults"), drawOptions);
}
google.setOnLoadCallback(OnLoad, true);

//]]>
</script>