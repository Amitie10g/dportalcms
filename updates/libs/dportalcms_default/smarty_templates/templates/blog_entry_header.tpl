<div class="content" id="content">
	<div class="blog_entry">

		{{if $smarty.session.blog_entry_saved}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.entry_published|ucfirst}}</div>
		{{elseif $smarty.session.blog_entry_error}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.entry_error|ucfirst}}</div>
		{{/if}}

		<h2 class="blog_entry_title">{{$TITLE}}</h2>
		<h3 class="blog_entry_date">{{$LANG.published_at}} {{$CREATED|date_format:"%m/%d/%Y %H:%M"}}{{if $IS_ADMIN}} | 
		<a href="{{LINK script='blog_edit' section=$NAME}}">{{$LANG.edit|ucfirst}}</a> | 
		<a href="{{LINK script='blog_delete' section=$NAME}}" onclick="return confirm('{{$LANG.delete_entry_warn|ucfirst}}');">{{$LANG.delete|ucfirst}}</a>{{/if}}</h3>
		<div style="border-bottom:1px black dotted">
				<div class="blog_entry" style="padding:10px">

