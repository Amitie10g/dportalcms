<div style="text-align:center">
{{if $LOGED_IN}}
<ul class="list">
<li class="list">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USERNAME}}</b></li>
{{if $IS_ADMIN}}{{if $EDITABLE}}
<li class="list"><a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" >{{$LANG.edit|ucfirst}} {{$LANG.page}}</a></li>
<li class="list"><a href="{{LINK script="panel" marker="#create_section"}}">{{$LANG.add|ucfirst}} {{$LANG.section}}</a></li>
{{/if}}
{{if $IS_BLOG}}<li class="list"><a href="{{LINK script='blog' page='NEW' argument="?NEW"}}">{{$LANG.new|ucfirst}} {{$LANG.entry}}</a></li>{{/if}}
<li class="list"><a href="{{LINK script='panel'}}" rel="external">{{$LANG.administration|ucfirst}}</a></li>
{{/if}}
{{if $PHPBB_URL_PATH != null}}<li class="list"><a href="{{$PHPBB_URL_PATH}}ucp.php">{{$LANG.goto_phpbb_panel|ucfirst}}  -&gt;</a></li>
{{/if}}
<li class="list"><a href="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=logout&amp;redirect={{$smarty.server.REQUEST_URI}}&amp;sid={{$PHPBB_SESSION_ID}}{{else}}{{LINK script='logout'}}{{/if}}">{{$LANG.logout}}</a></li>
</ul>
{{else}}
{{include file="sidebar_login.tpl"}}
{{/if}}
</div>
<hr />
