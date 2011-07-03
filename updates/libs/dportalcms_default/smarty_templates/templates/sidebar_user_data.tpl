<div style="text-align:center;padding: 5px">

{{* If user is loged in *}}
{{if $LOGED_IN}}

<div style="margin-bottom:5px">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USER_NICK}}</b></div>

{{* Edit Sections *}}
{{if $EDITABLE}}
<div class="sidebar_link"><a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" rel="nofollow">{{$LANG.edit|ucfirst}} {{$LANG.page}}</a></div>
<div class="sidebar_link"><a href="{{LINK script='panel' section="/sections/create_section"}}" rel="nofollow">Add Section</a></div>
{{/if}}

{{* Gallery mode *}}
{{if $IS_GALLERY}}
<div class="sidebar_link"><a href="{{LINK script='panel' section="gallery/edit:$GALLERY_NAME" argument="?NEW"}}">Edit/Upload</a></div>
{{/if}}

{{* Blog mode *}}
{{if $IS_BLOG}}
<div class="sidebar_link"><a href="{{LINK script='blog' page='NEW' argument="?NEW"}}">{{$LANG.new|ucfirst}} {{$LANG.entry}}</a></div>
{{/if}}

{{* Media player mode *}}
{{if $IS_MEDIA_PLAYER}}
{{if !empty($PLAYLIST_GET)}}
<div class="sidebar_link"><a href="{{LINK script='panel' page="videos/upload:$PLAYLIST_GET" argument="?NEW"}}">Upload/Edit</a></div>
{{/if}}
<div class="sidebar_link"><a href="{{LINK script='panel' page="videos/create" argument="?NEW"}}">Create Playlist</a></div>
{{/if}}

{{* Link to Administration panel *}}
{{if $IS_ADMIN}}
<div class="sidebar_link"><a href="{{LINK script='panel'}}" rel="external">{{$LANG.administration|ucfirst}}</a></div>
{{/if}}

{{* Link to phpBB User control panel (if exist) *}}
{{if $PHPBB_URL_PATH != null}}
<div class="sidebar_link"><a href="{{$PHPBB_URL_PATH}}ucp.php" rel="nofollow">{{$LANG.goto_phpbb_panel|ucfirst}}</a></div>
{{if $IS_ADMIN}}<div class="sidebar_link"><a href="{{$PHPBB_URL_PATH}}/adm" rel="nofollow">Go to phpBB Administration{{$LANG.goto_phpbb_adm|ucfirst}}</a></div>{{/if}}
{{/if}}

<div><a href="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=logout&redirect={{$smarty.server.REQUEST_URI}}&sid={{$PHPBB_SESSION_ID}}{{else}}{{LINK script='logout' section=$smarty.server.REQUEST_URI}}{{/if}}" rel="nofollow">{{$LANG.logout|ucfirst}}</a></div>

{{* Elsewhere if not loged in, prompt the Login *}}
{{else}}
{{include file="sidebar_login.tpl"}}
{{/if}}
</div>
<hr />
