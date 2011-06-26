<h1>{{$TITLE}}</h1>

{{if $smarty.session.AUTHOR_NOT_EXIST}}
<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.author_not_exist|ucfirst}}</div>
{{/if}}

{{section name="books" loop=$BOOKS}}
<div style="max-width:600px;border:1px #000000 dotted;margin:10px auto;padding:3px">
<h2 style="margin:0;font-size:15px;{{if $ALLOWED_EDIT}}float:left{{/if}}"><a href="{{LINK script="chapter" section="1" page=$BOOKS[books].name}}">{{$BOOKS[books].title}}</a></h2>{{if $ALLOWED_EDIT}}&nbsp;<span style="font-size:8px">({{$BOOKS[books].reads|default:"No"}} {{$LANG.reads}}reads)</span>{{/if}}
<p style="margin:5px 10px">{{$BOOKS[books].summary}}</p>
<p style="margin:5px 0"><span style="font-weight:bold">{{$LANG.author|ucfirst}}:</span> <a href="{{LINK script="books_filter_author" section=$BOOKS[books].author}}" title="{{$LANG.see_stories_author}}">{{$BOOKS[books].author|get_user_by_id}}</a>{{if $USE_PHPBB && $LOGED_IN}} [<a href="{{$PHPBB_URL_PATH}}memberlist.php?mode=viewprofile&u={{$BOOKS[books].author}}" rel="external"  title="{{$LANG.view_profile|ucfirst}}">{{$LANG.profile|ucfirst}}</a>] [<a href="{{$PHPBB_URL_PATH}}ucp.php?i=pm&mode=compose&u={{$BOOKS[books].author}}" rel="external"  title="{{$LANG.send_private_message|ucfirst}}">{{$LANG.private_message|ucfirst}}</a>]{{/if}}</p>
</div>
{{/section}}

