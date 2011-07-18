<div style="padding:5px">{{$LANG.phpbb_int_warn|ucfirst}}</div>

<form method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='config:update' argument='?SITE_CONF'}}{{else}}{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}{{/if}}">
  <div style="width:70%;margin:auto;text-align:center">
  <strong>{{$LANG.phpbb_path}}:</strong> <input type="text" name="phpbb_dir"
  value="{{$PHPBB_DIR}}" style="width:55%" />
  </div>

  <div style="text-align:center;padding:10px">
  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" />
  </div>
</form>
