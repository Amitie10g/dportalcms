{{if $BACKUPS != null}}
<h5 onclick="items(23)" class="titre"
style="cursor:pointer">{{$LANG.download_backup|ucfirst}}</h5>

<div style="text-align:center;padding: 0 0 10px 0">

<div>
{{$LANG.download_backup_preface|ucfirst}}</div>

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
{{/if}}

<h5 onclick="items(22)" class="titre"
style="cursor:pointer">{{$LANG.create_backup}}</h5>

<div id="item_22" style="text-align:left;padding:7px">

<div>
{{$LANG.create_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:create' argument='?BACKUP'}}">

  <div style="text-align:center;">
  <label><input type="checkbox" checked="checked" disabled="disabled"/>{{$LANG.sections|ucfirst}}</label>
  <label><input type="checkbox" name="mode[blog]" value="true" />{{$LANG.blog|ucfirst}}</label>
  <label><input type="checkbox" name="mode[config]" value="true" />{{$LANG.config|ucfirst}}</label>
  <label><input type="checkbox" name="mode[templates]" value="true" />{{$LANG.templates|ucfirst}}</label>

  </div>

  <div style="text-align:center;margin:10px 0 0 3px">

  <input type="submit" value="  Perform  " /> </div>
</form>

<div style="clear:both">
</div>
</div>

<div style="text-align:center;padding: 0 5px 10px 5px">
<h5 onclick="items(24)" class="titre"
style="cursor:pointer">{{$LANG.restore_backup}}</h5>

<div>

<div style="padding: 0 5px 10px 5px">
{{$LANG.restore_backup_preface}}</div>

<div style="text-align:center">
<form method="post"
action="{{LINK script='panel' section='backup:restore' argument='?RESTORE'}}"
enctype="multipart/form-data">
  <div><input name="filename" type="file" /></div>

  <div style="tet-align:center;padding: 10px">
  <input type="submit" value="  Upload  " /></div>
</form>
</div>
</div>
{{if $BACKUPS != null}}
<div style="text-align:center;padding: 0 0 10px 0">
<h5 onclick="items(25)" class="titre"
style="cursor:pointer">{{$LANG.delete_backups|ucfirst}}</h5>

<div id="item_25" class="hidden">

<div style="margin:5px;text-align:left">
{{$LANG.delete_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:delete' argument='?DELETE_BACKUPS'}}">
  <div><label><input name="no_last" type="checkbox" checked="checked"
  value="true" />All except last</label> 
  <input type="submit" value="  {{$LANG.delete|ucfirst}}  " /></div>
</form>
</div>
</div>

{{/if}}
</div>
