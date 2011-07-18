<div style="padding:0 5px 10px 5px">{{$LANG.change_pass_warn}} </div>
<form id="form1" method="post"
action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='config:update' argument='?SITE_CONF'}}{{else}}{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}{{/if}}">
<div style="width:50%;margin:auto;text-align:right">
  <span><strong>{{$LANG.current_username|ucfirst}}:</strong> <input type="text"
  name="curr_user" style="width:220px" /> </span><br />

  <span><strong>{{$LANG.current_password|ucfirst}}:</strong> <input
  type="password" name="curr_pass" style="width:220px" /> </span><br />

  <span><strong>{{$LANG.new_username|ucfirst}}:</strong> <input type="text"
  name="username" style="width:220px" /> </span><br />

  <span><strong>{{$LANG.new_password|ucfirst}}:</strong> <input type="password"
  name="password" style="width:220px" /> </span><br />

  <span><strong>{{$LANG.repeat_password|ucfirst}}:</strong> <input type="password"
  name="password_repeat" style="width:220px" /> </span><br />
</div>
<div style="text-align:center;padding:10px">
  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" />
</div>
</form>
 