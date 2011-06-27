<h2 style="margin:0;font-size: 14px;text-align:center">{{$LANG.search|ucfirst}}Search</h2>
<div style="text-align:center">

<form method="post" action="{{LINK script='books_search'}}">
	<p style="margin:0"><span>Keywords: <input type="text" name="keywords" style="width:118px" /></span></p>
	<div style="display:inline-table">
		<select name="type" style="width:118px">
			<option selected="selected" value="0">Search Story (default)</option>
			<option value="1">Story (in sumary too)</option>
			<option value="2">Author</option>
		</select>
	</div>
	
	<div style="display:inline-table">
		<select name="category" style="width:118px;margin:0">
		{{section name="category" loop=$BOOK_CATEGORIES}}
		<option{{if $BOOK_CATEGORIES[category].type == 0}} selected = "selected" disabled="disabled"{{elseif $BOOK_CATEGORIES[category].type == 1}} disabled="disabled"{{elseif $BOOK_CATEGORIES[category].type == 2}} value="{{$BOOK_CATEGORIES[category].id}}"{{/if}} title="{{if $BOOK_CATEGORIES[category].type == 1}}{{$LANG.category|ucfirst}}: {{elseif $BOOK_CATEGORIES[category].type == 2}}{{$LANG.genere|ucfirst}}: {{/if}}{{$BOOK_CATEGORIES[category].string|replace:'  * ':''}}">{{$BOOK_CATEGORIES[category].string}}</option>
		{{/section}}
		</select>
	</div>
	
	<div style="display:inline-table">
		<select name="lang" style="width:99%;margin:0">
		{{section name="lang" loop=$BOOK_LANGS}}
		{{if $smarty.section.lang.index > 0}}<option{{if $smarty.section.lang.index == 1}} selected = "selected" disabled="disabled"{{/if}} value="{{$BOOK_LANGS[lang].name}}" title="{{$BOOK_LANGS[lang].string}})">{{$BOOK_LANGS[lang].string}}</option>{{/if}}
		{{/section}}
		</select>
	</div>
	
	<p><input type="submit" value="Search" style="width:118px" /></p>
	</form>
	
	<p><a href="{{LINK script="books_search"}}">{{$LANG.advanced_search|ucfirst}}Advanced search</a></p>
</div>