<div style="padding:10px;">{{$LANG.create_playlist_preface}}</div>

<div style="text-align:right;width:400px;margin:auto">

<form method="post"
action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='video:create' argument='?CREATE_SHOWCASE'}}{{else}}{{LINK script='panel' section='video:create' argument='?CREATE_SHOWCASE'}}{{/if}}">

  <div>
  <strong>{{$LANG.name|ucfirst}}:</strong> <input type="text" name="name"
  style="width:250px" /></div>

  <div>
  <strong>{{$LANG.title|ucfirst}}</strong>: <input type="text" name="title"
  style="width:250px" /></div>

  <div style="text-align:center">
  <input type="submit" value="Create" /> </div>
</form>
</div>
