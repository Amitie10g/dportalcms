<div style="width:99%;margin:auto">
<form method="post" action="{{LINK script='panel' section='template:save' argument='?TEMPLATE_SAVE'}}">
  <input type="submit" value="{{$LANG.save|ucfirst}}" />
<textarea name="content" cols="20" rows="50" style="width:99.5%;height:450px;font-size:14px">{{fetch file=$FILE}}</textarea>
<input type="hidden" name="file" value="{{$NAME}}" />
</form>
</div>
