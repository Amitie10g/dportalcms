<div class="content">
<a name="content" title="{{$LANG.content}}"></a>
	<div class="blog_entry">
	<a name="entry"></a>
{{BLOG_MESSAGE stype='entry' dtype=$MESSAGE.0 message=$MESSAGE.1}}
		<h2 class="blog_entry_title">{{$TITLE}}</h2>
		<h3 class="blog_entry_date">Published at {{$ID|date_format:"%m/%d/%Y"}}  {{$ID|date_format:"%H:%M"}}{{if $IS_ADMIN}} | 
		<a href="{{LINK script='blog_edit' section=$NAME}}">{{$LANG.edit|ucfirst}}</a> | 
		<a href="{{LINK script='blog_delete' section=$NAME}}" onclick="return confirm('{{$LANG.delete_entry_warn|ucfirst}}');">{{$LANG.delete|ucfirst}}</a>{{/if}}</h3>
		<div style="border-bottom:1px black dotted">
				<div class="blog_entry" style="padding:10px">

