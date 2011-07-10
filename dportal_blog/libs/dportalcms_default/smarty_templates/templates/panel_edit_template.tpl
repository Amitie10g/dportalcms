<div style="text-align:center;padding:5px 5px 15px 5px">{{$LANG.edit_templates_preface}}<br />
<strong>{{$LANG.warning|ucfirst}}:</strong> {{$LANG.incorrect_edition_warn|ucfirst}}</div>
<div style="width:50%;text-align:center;margin:auto;padding: 0 0 10px 0">
<form method="post" action="{{LINK script='panel'}}">
  <span>
  <select class="list" name="template_file" onchange="submit();"
  style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_template_to_edit|ucfirst}}</option>
	{{section name="templates" loop=$TEMPLATES}}
    {{if (strpos($TEMPLATES[templates].name,'panel_') === false) && (strpos($TEMPLATES[templates].name,'edit') === false)}}<option value="{{$TEMPLATES[templates].name}}"{{if $TEMPLATES[templates].name == $smarty.get.template_file}} selected="selected"{{/if}}>{{$TEMPLATES[templates].name}}</option>{{/if}}
	{{/section}}
  </select>
   </span>
</form>
</div>

{{if !empty($smarty.get.template_file)}}
{{include file="template_edit.tpl"}}
{{/if}}
