<div style="text-align:center;padding: 5px">

{{* If user is loged in *}}
{{if $LOGED_IN}}

<div style="margin-bottom:5px">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USER_NICK}}</b></div>

{{* Edit Sections *}}
{{if $EDITABLE}}
<a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" rel="nofollow">{{$LANG.edit|ucfirst}} {{$LANG.page}}</a>
{{/if}}

{{* Gallery mode *}}
{{if $IS_GALLERY}}
<div><a href="{{LINK script='panel' section="gallery/edit:$GALLERY_NAME" argument="?NEW"}}">Edit Gallery</a></div>
{{/if}}

{{* Blog mode *}}
{{if $IS_BLOG}}
<div><a href="{{LINK script='blog' page='NEW' argument="?NEW"}}">{{$LANG.new|ucfirst}} {{$LANG.entry}}</a>
</div>
{{/if}}

{{* Media player mode *}}
{{if $IS_MEDIA_PLAYER}}
{{if $IS_PLAYLIST}}
<div><a href="{{LINK script='panel' page="videos/upload:$PLAYLIST_GET" argument="?NEW"}}">Upload/Edit</a></div>
{{/if}}
<div><a href="{{LINK script='panel' page="videos/create" argument="?NEW"}}">Create Playlist</a></div>
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
