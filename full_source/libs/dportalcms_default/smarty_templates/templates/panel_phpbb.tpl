<div style="padding:5px">{{$LANG.phpbb_int_warn}}</div>

<form method="post" action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">
  <div style="width:70%;margin:auto;text-align:center">
  <strong>{{$LANG.phpbb_path}}:</strong> <input type="text" name="phpbb_dir"
  value="{{$PHPBB_DIR}}" style="width:55%" />
  </div>

  <div style="text-align:center;padding:10px">
  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" />
  </div>
</form>
