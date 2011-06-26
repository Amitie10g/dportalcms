<h1>{{$TITLE}}</h1>

{{DYNAMIC}}
{{if $smarty.session.AUTHOR_NOT_EXIST}}
<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.author_not_exist|ucfirst}}</div>
{{/if}}{{if $smarty.session.BOOK_NOT_CREATED}}
<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.create_book_error|ucfirst}}</div>{{/if}}
{{/DYNAMIC}}

<div style="width:auto;max-width:450px;padding:3px;border:#000000 1px dashed;margin:auto">

{{if $TYPE == $smarty.const.SR_STORIES}}
{{section name="story" loop=$STORIES}}
<div style="width:100%;border:1px #000000 dotted;margin-bottom:10px">
	<h2 style="text-align:left;font-size:15px;margin:0"><a href="{{LINK script='chapter' argument=$STORIES[story].author section='1' page=$STORIES[story].name}}">{{$STORIES[story].title}}</a></h2>
	<span><span style="font-weight:bold">{{$LANG.author|ucfirst}}:</span> <a href="{{LINK script='books_filter_author' section=$STORIES[story].author|get_user}}">{{$STORIES[story].author|get_user}}</a></span>
	<div style="margin:10px">{{$STORIES[story].summary}}</div>
</div>
{{/section}}
{{/if}}
</div>

