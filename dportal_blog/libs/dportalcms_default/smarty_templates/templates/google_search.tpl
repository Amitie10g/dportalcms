<script src="http://www.google.com/jsapi" type="text/javascript"></script>

<script type="text/javascript">//<![CDATA[

google.load("search", "1.0");

function OnLoad() {

var searchControl = new
google.search.CustomSearchControl
("{{$CSE_KEY}}");

searchControl.setLinkTarget
(google.search.Search.LINK_TARGET_SELF);
searchControl.setResultSetSize
(google.search.Search.SMALL_RESULTSET);

var drawOptions = new google.search.DrawOptions();

drawOptions.setDrawMode
(google.search.SearchControl.DRAW_MODE_TABBED);

drawOptions.setSearchFormRoot(document.getElementById
("search_control_tabbed"));

searchControl.draw(document.getElementById
("searchResults"), drawOptions);
}
google.setOnLoadCallback(OnLoad, true);

//]]></script>
