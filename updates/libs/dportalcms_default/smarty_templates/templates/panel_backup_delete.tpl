<<<<<<< .mine
<div style="padding: 10px">

	<div>{{$LANG.delete_backup_preface}}</div>
	
	<div style="text-align:center">
		<form method="post"
		action="{{LINK script='panel' section='backup:delete' argument='?DELETE_BACKUPS'}}">
		  <div><label><input name="no_last" type="checkbox" checked="checked"
		  value="true" />All except last</label> 
		  <input type="submit" value="  {{$LANG.delete|ucfirst}}  " /></div>
		</form>
	</div>
</div>

=======
<div style="padding: 10px">

	<div>{{$LANG.delete_backup_preface}}</div>
	
	<div style="text-align:center">
		<form method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='backup:delete' argument='?DELETE_BACKUPS'}}{{else}}{{LINK script='panel' section='backup:delete' argument='?DELETE_BACKUPS'}}{{/if}}">
		  <div><label><input name="no_last" type="checkbox" checked="checked"
		  value="true" />All except last</label> 
		  <input type="submit" value="  {{$LANG.delete|ucfirst}}  " /></div>
		</form>
	</div>
</div>

>>>>>>> .r184
