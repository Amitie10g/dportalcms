
<div style="text-align:left;padding:10px">

<div>{{$LANG.create_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:create' argument='?BACKUP'}}">

  <div style="text-align:center;">
  <label><input type="checkbox" checked="checked" disabled="disabled"/>{{$LANG.entries|ucfirst}}</label>
  <label><input type="checkbox" name="mode[comments]" value="true" />{{$LANG.comments|ucfirst}}</label>
  <label><input type="checkbox" name="mode[templates]" value="true" />{{$LANG.templates|ucfirst}}</label>
  <label><input type="checkbox" name="mode[config]" value="true" />{{$LANG.config|ucfirst}}</label>

  </div>

  <div style="text-align:center;margin:10px 0 0 3px">

  <input type="submit" value="  Perform  " /> </div>
</form>
</div>
