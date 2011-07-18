<div style="width:99%;margin:auto">
<form name="template_editor_form" method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='template:save' argument='?TEMPLATE_SAVE'}}{{else}}{{LINK script='panel' section='template:save' argument='?TEMPLATE_SAVE'}}{{/if}}">
  <noscript><input type="submit" value="{{$LANG.save|ucfirst}}" /></noscript>
<textarea id="template_editor" name="content" cols="20" rows="50" style="width:99.5%;height:450px;font-size:14px">{{fetch file=$FILE}}</textarea>
<input type="hidden" name="file" value="{{$NAME}}" />
</form>
</div>
