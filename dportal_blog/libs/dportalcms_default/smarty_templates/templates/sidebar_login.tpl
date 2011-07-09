
<form action="{{$smarty.server.PHP_SELF}}?LOGIN" method="post" style="margin:0;padding:0">
<p style="text-align:center;margin:2px">{{$LANG.username|ucfirst}}:
  <input style="width:95%" size="10" name="username" /></p>
<p style="text-align:center;margin:2px">{{$LANG.password|ucfirst}}:
  <input style="width:95%" type="password" maxlength="32"  name="password" /></p>
<p style="text-align:center;margin:2px"><input type="hidden" value="{{$smarty.server.REQUEST_URI}}" name="redirect" />
<input style="width:100%" type="submit" value="  Login  " name="login" />
</form>

