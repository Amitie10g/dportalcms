<div class="content">
<a name="content"></a>
<h3 style="text-align:center"><i>{{$LANG.view_please_login|ucfirst}}.</i></h3>
<form action="{{$PHPBB_URL_PATH}}ucp.php?mode=login" method="post">
<table style="margin:auto">
<tr>
<td style="text-align:right">{{$LANG.username|ucfirst}}:</td>
<td><input style="width:150px" size="10" name="username" /></td>
</tr>
<tr>
<td style="text-align:right">{{$LANG.password|ucfirst}}:</td>
<td><input style="width:150px" type="password" name="password" /></td>
</tr>
<tr>
<td></td>
<td>
<input type="hidden" value="{{$smarty.server.REQUEST_URI}}" name="redirect" />
<input style="width:98%" type="submit" value="  Login  " name="login" />
</td>
</tr>
<tr>
<td><a href="{{$PHPBB_URL_PATH}}ucp.php?mode=register">Register</a></td>
<td><a href="{{$PHPBB_URL_PATH}}ucp.php?mode=sendpassword">Forgot password?</a></td>
</tr>
</table>
</form>
</div>
