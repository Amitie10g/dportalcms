
<div style="text-align:center;padding: 5px">

{{* If user is loged in *}}
{{if $LOGED_IN}}

<div style="margin-bottom:5px">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USER_NICK}}</b></div>

{{* Blog mode *}}
{{if $IS_BLOG}}
<div class="sidebar_link"><a href="{{LINK script='blog' page='NEW' argument="?NEW"}}" rel="external">{{$LANG.new|ucfirst}} {{$LANG.entry}}</a></div>
{{/if}}

{{* Link to Administration panel *}}
{{if $IS_ADMIN}}
<div class="sidebar_link"><a href="{{LINK script='panel'}}" rel="external">{{$LANG.administration|ucfirst}}</a></div>
{{/if}}

<div><a href="{{LINK script='logout' section=$smarty.server.REQUEST_URI}}" rel="nofollow">{{$LANG.logout|ucfirst}}</a></div>

{{* Elsewhere if not loged in, prompt the Login *}}
{{else}}
{{include file="sidebar_login.tpl"}}
{{/if}}
</div>
<hr />
