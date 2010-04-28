<form action="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=login{{else}}{{$smarty.server.PHP_SELF}}?LOGIN{{/if}}" method="post" style="margin:0;padding:0">
<p style="text-align:center;margin:2px">{{$LANG.username|ucfirst}}:
  <input style="width:95%" size="10" name="username" /></p>
<p style="text-align:center;margin:2px">{{$LANG.password|ucfirst}}:
  <input style="width:95%" type="password" maxlength="32"  name="password" /></p>
<p style="text-align:center;margin:2px"><input type="hidden" value="{{$smarty.server.REQUEST_URI}}" name="redirect" />
<input style="width:100%" type="submit" value="  Login  " name="login" />
{{if $PHPBB_URL_PATH != null}}<p style="text-align:center;margin:0"><a href="{{$PHPBB_URL_PATH}}ucp.php?mode=register">{{$LANG.register|ucfirst}}</a></p>{{else}}<input type="hidden" name="redir" value="{{$smarty.server.REQUEST_URI}}" />{{/if}}</p>
</form>

