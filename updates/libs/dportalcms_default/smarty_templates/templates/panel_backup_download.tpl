<<<<<<< .mine
<div style="padding: 10px">{{$LANG.download_backup_preface|ucfirst}}</div>

<div style="text-align:center;padding: 0 0 10px 0">
<form method="post"
action="{{LINK script='panel' section='backup:download' argument='?DOWNLOAD_BACKUP'}}">
  <div>
  <select class="list" name="filename" onchange="submit()">
    <option class="list" selected="selected" disabled="disabled">Select a
    Backup File</option>{{section name="backups" loop="$BACKUPS}}
    <option
    value="{{$BACKUPS[backups]}}">{{$BACKUPS[backups]}}</option>{{sectionelse}}
    <option
    disabled="disabled">{{$LANG.no_backups|ucfirst}}</option>{{/section}}
  </select>
   </div>
</form>
</div>
=======
<div style="padding: 10px">{{$LANG.download_backup_preface|ucfirst}}</div>

<div style="text-align:center;padding: 0 0 10px 0">
<form method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='backup:download' argument='?DOWNLOAD_BACKUP'}}{{else}}{{LINK script='panel' section='backup:download' argument='?DOWNLOAD_BACKUP'}}{{/if}}">
  <div>
  <select class="list" name="filename" onchange="submit()">
    <option class="list" selected="selected" disabled="disabled">Select a
    Backup File</option>
	{{if $smarty.const.DEMO_CPANEL !== true}}
	{{section name="backups" loop="$BACKUPS}}
    <option value="{{$BACKUPS[backups]}}">{{$BACKUPS[backups]}}</option>{{sectionelse}}<option disabled="disabled">{{$LANG.no_backups|ucfirst}}</option>
	{{/section}}
	{{/if}}
  </select>
   </div>
</form>
</div>
>>>>>>> .r184
