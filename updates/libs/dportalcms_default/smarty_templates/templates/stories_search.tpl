<h1 style="margin:10px">{{$TITLE}}</h1>

{{DYNAMIC}}
{{if $smarty.session.AUTHOR_NOT_EXIST}}<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.author_not_exist|ucfirst}}</div>{{/if}}
{{if $smarty.session.BOOK_NOT_CREATED}}<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.create_book_error|ucfirst}}</div>{{/if}}
{{if $RESULT === false}}<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">Sorry, but <strong>not results has been returned</strong> from your search. Please review the keywords and optional criteria.</div>{{/if}}
{{/DYNAMIC}}

<div style="width:auto;max-width:450px;padding:3px;border:#000000 1px dashed;margin:auto;text-align:center">
    <h3 style="margin:0">Main options</h3>
	<form method="post" action="{{LINK script='books_search'}}">
    <p>
	
	<span style="font-weight:bold">Keywords:</span> <input type="text" name="keywords" style="width:210px" />
	<select name="type" style="width:132px">
			<option selected="selected" value="0">Search for Story (default)</option>
			<option value="1">Story and Summary</option>
			<option value="2">Author</option>
		</select>
	</p>
	<h3>Other options</h3>
	<div style="display:inline-table">
		<select name="category" style="width:130px;margin:0">
		{{section name="category" loop=$BOOK_CATEGORIES}}
		<option{{if $BOOK_CATEGORIES[category].type == 0}} selected = "selected" disabled="disabled"{{elseif $BOOK_CATEGORIES[category].type == 1}} disabled="disabled"{{elseif $BOOK_CATEGORIES[category].type == 2}} value="{{$BOOK_CATEGORIES[category].id}}"{{/if}} title="{{if $BOOK_CATEGORIES[category].type == 1}}{{$LANG.category|ucfirst}}: {{elseif $BOOK_CATEGORIES[category].type == 2}}{{$LANG.genere|ucfirst}}: {{/if}}{{$BOOK_CATEGORIES[category].string|replace:'  * ':''}}">{{$BOOK_CATEGORIES[category].string}}</option>
		{{/section}}
		</select>
	</div>
	
	<div style="display:inline-table">
		<select name="lang" style="width:135px;margin:0">
		{{section name="lang" loop=$BOOK_LANGS}}
		{{if $smarty.section.lang.index > 0}}<option{{if $smarty.section.lang.index == 1}} selected = "selected" disabled="disabled"{{/if}} value="{{$BOOK_LANGS[lang].name}}" title="{{$BOOK_LANGS[lang].string}})">{{$BOOK_LANGS[lang].string}}</option>{{/if}}
		{{/section}}
		</select>
	</div>
	
	<div style="display:inline-table">
	
		<select name="points" style="width:80px;margin:0">
			<option selected="selected" disabled="disabled">At least</option>
			<option value="10" title="10 Points (Absolute beginer)">10 Points</option>
			<option value="50" title="50 Points (Begimer)">50 Points</option>
			<option value="100" title="100 Points (Known)">100 Points</option>
			<option value="500" title="500 Points (Rookie)">500 Points</option>
			<option value="1000" title="1000 Points (Talented)">1000 Points</option>
			<option value="25000" title="25000 Points (In glory)">25000 Points</option>
			<option value="50000" title="50000 Points (King)">50000 Points</option>
			<option value="100000" title="100000 Points (God)">100000 Points</option>
		</select>
	
	</div>
	
	<div style="display:inline-table">
		<label><input type="checkbox" name="mature" value="1" />Mature</label>
	</div>
	
	<p><input type="submit" value="Search" style="font-size:16px;width:130px" /></p>
	</form>
</div>

