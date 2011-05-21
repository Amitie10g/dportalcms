<script type="text/javascript">
google.load("search", "1");

// Google Search API
function OnLoad() {
// Create a search control
    var searchControl = new google.search.SearchControl();

    // site restricted web search with custom label and class suffix
	var siteSearch = new GwebSearch();
  	siteSearch.setUserDefinedLabel("{{$SITENAME}}");
	siteSearch.setUserDefinedClassSuffix("siteSearch");
  	siteSearch.setSiteRestriction("{{$smarty.server.SERVER_NAME}}");
	searchControl.addSearcher(siteSearch);

    // Tell the searcher to draw itself and tell it where to attach
    searchControl.draw(document.getElementById("searchcontrol"));

}
google.setOnLoadCallback(OnLoad);
</script>