<div style="text-align:center;padding: 5px">

{{* If user is loged in *}}
{{if $LOGED_IN}}

<div style="margin-bottom:5px">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USER_NICK}}</b></div>

{{* Edit Sections *}}
{{if $EDITABLE}}
<a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" rel="nofollow">{{$LANG.edit|ucfirst}} {{$LANG.page}}</a><br />
<form method="post" action="{{LINK script='panel' section='section:create' argument="?CREATE"}}">
<p style="margin:5px 0"><span>{{$LANG.add_section|ucfirst}}:</span><br />
<span><input type="text" name="filename" value="{{$LANG.name|ucfirst}}" title="" style="width:97%;margin:0" onclick="javascript:this.value=''" /></span><br />
<span><input type="text" name="title" value="{{$LANG.title|ucfirst}}" title="" style="width:97%;margin:0" onclick="javascript:this.value=''" /></span><br />
<span><input type="hidden" name="category" value="{{$CATEGORY_NAME}}"></span>
<span><input type="submit" style="width:100%;margin:0" value="{{$LANG.create_and_edit|ucfirst}}" /></span></p>
</form>

<p style="margin:0 0 3px 0">{{$LANG.add_another_category}}<span style="cursor:pointer" title="Want to add section to other category? Go to Panel.">Other category?</span></p>
{{/if}}

{{* Gallery mode *}}
{{if $IS_GALLERY}}
<div><a href="{{LINK script='panel' section="gallery/edit:$GALLERY_NAME" argument="?NEW"}}">Edit Gallery</a></div>

{{/if}}

{{* Blog mode *}}
{{if $IS_BLOG}}
<div><a href="{{LINK script='blog' page='NEW' argument="?NEW"}}">{{$LANG.new|ucfirst}} {{$LANG.entry}}</a>
<hr />
</div>
{{/if}}

{{* Link to Administration panel *}}
{{if $IS_ADMIN}}
<a href="{{LINK script='panel'}}" rel="external">{{$LANG.administration|ucfirst}}</a><br />
{{/if}}

{{* Link to phpBB User control panel (if exist) *}}
{{if $PHPBB_URL_PATH != null}}
<a href="{{$PHPBB_URL_PATH}}ucp.php" rel="nofollow">{{$LANG.goto_phpbb_panel|ucfirst}}</a><br />
{{/if}}

<a href="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=logout&redirect={{$smarty.server.REQUEST_URI}}&sid={{$PHPBB_SESSION_ID}}{{else}}{{LINK script='logout' section=$smarty.server.REQUEST_URI}}{{/if}}" rel="nofollow">{{$LANG.logout|ucfirst}}</a>

{{* Elsewhere if not loged in, prompt the Login *}}
{{else}}
{{include file="sidebar_login.tpl"}}
{{/if}}
</div>
<hr />
