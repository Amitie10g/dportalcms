<div style="padding: 10px">
<div>{{$LANG.restore_backup_preface}}</div>

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
