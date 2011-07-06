<div style="padding:5px">{{$LANG.cse_warn}}</div>

<form method="post" action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">
  <div style="width:70%;margin:auto;text-align:center">
  <strong>Google CSE Key{{$LANG.cse_key}}:</strong> <input type="text" name="cse_key"
  value="{{$CSE_KEY}}" style="width:55%" />
  </div>

  <div style="text-align:center;padding:10px">
  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" />
  </div>
</form>
