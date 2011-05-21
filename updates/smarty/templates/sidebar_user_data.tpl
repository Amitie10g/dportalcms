<div style="text-align:center">

{{* If user is loged in *}}
{{if $LOGED_IN}}

<div style="margin-bottom:5px">{{$LANG.hello|ucfirst}} <b>{{$PHPBB_USER_NICK}}</b></div>

{{* Edit Sections *}}
{{if $EDITABLE}}
<a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" rel="nofollow">{{$LANG.edit|ucfirst}} {{$LANG.page}}</a><br />
<form method="post" action="{{LINK script='panel' section='section:create' argument="CREATE"}}">
<p style="margin:5px 0"><span>{{$LANG.add_section|ucfirst}}:</span><br />
<span><input type="text" name="filename" value="{{$LANG.name|ucfirst}}" title="" style="width:97%;margin:0" onclick="javascript:this.value=''" /></span><br />
<span><input type="text" name="title" value="{{$LANG.title|ucfirst}}" title="" style="width:97%;margin:0" onclick="javascript:this.value=''" /></span><br />
<span><input type="hidden" name="category" value="{{$CATEGORY_NAME}}"></span>
<span><input type="submit" style="width:100%;margin:0" value="{{$LANG.create_and_edit|ucfirst}}" /></span></p>
</form>

<p style="margin:0 0 3px 0">{{$LANG.add_another_category}}<span style="cursor:pointer" title="Want to add section to other category? Go to Panel.">Other category?</span></p>
{{/if}}

{{* Books mode *}}
{{if $IS_BOOK}}
{{if $CHAPTERS != null && $ALLOWED_EDIT}}
<div style="margin:10px 0">
<p style="margin:5px"><a href="{{LINK script='edit_chapter' section=$CHAPTER  page=$BOOK argument='?section='}}" rel="nofollow">{{$LANG.edit_chapter|ucfirst}}</a></p>

<form method="post" action="{{LINK script='books' page='ADD_CHAPTER'}}">
<p><span>{{$LANG.add_chapter|ucfirst}}:<br />
<input type="text" name="title" value="{{$LANG.title|ucfirst}}" title="Title: The title of the chapter." style="width:97%;margin:0" onclick="javascript:this.value=''" /></span>
<span><input type="hidden" name="book" value="{{$BOOK}}" /></span><br />
<span><input type="submit" style="width:100%;margin:0" value="{{$LANG.create_and_edit|ucfirst}}" /></span></p>
</form></div>
{{/if}}

<div style="margin:10px 0"><form method="post" action="{{LINK script='books' page='CREATE_BOOK'}}">
<div><span>{{$LANG.create_book|ucfirst}}<br />
<input type="text" name="title" value="{{$LANG.title|ucfirst}}" style="width:97%;margin:0" title="Title: The name of book. URI name will be converted automatically." onclick="javascript:this.value=''" /><br /></span>
<input type="text" name="summary" value="{{$LANG.summary|ucfirst}}Summary" style="width:97%;margin:0" title="Summary: Summary or description of the book." onclick="javascript:this.value=''" />
<p style="margin:5px 0">
<select name="license" style="width:99%;margin:0" title="{{$LANG.select_license}}">
<option selected="selected" disabled="disabled" title="{{$LANG.default_copyrighted}}">{{$LANG.license}}</option>
<option value="1" title="{{$LANG.cc-by_title}}">Creative Commons [by]</option>
<option value="2" title="{{$LANG.cc-by-nc-nd_title}}">Creative Commons [by-nc-nd]</option>
<option value="3" title="{{$LANG.cc-by-nc-sa_title}}">Creative Commons [by-nc-sa]</option>
<option value="4" title="Public Domain">{{$LANG.public_domain}}</option>
<option value="5" title="Custom">{{$LANG.custom_other|ucfirst}}</option>
</select>
</p>
<span><input type="submit" style="width:100%;margin:0" value="{{$LANG.create_and_edit|ucfirst}}" /></span></div>
<div style="font-size:8px"><span style="font-weight:bold">Note:</span> Name will be automatically con-<br />verted to proper format from Title.</div>
</form></div>

<hr />
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

<a href="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=logout&amp;redirect={{$smarty.server.REQUEST_URI}}&amp;sid={{$PHPBB_SESSION_ID}}{{else}}{{LINK script='logout' section=$smarty.server.REQUEST_URI}}{{/if}}" rel="nofollow">{{$LANG.logout|ucfirst}}</a>

{{* Elsewhere if not loged in, prompt the Login *}}
{{else}}
{{include file="sidebar_login.tpl"}}
{{/if}}
</div>
<hr />
