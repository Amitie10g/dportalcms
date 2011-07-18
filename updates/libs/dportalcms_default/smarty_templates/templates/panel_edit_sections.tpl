<div style="text-align:center;padding:10px 5px">{{$LANG.sections_warn}}</div>	
<div style="width:400px;margin:auto;padding:10px;text-align:center"> 
  <form id="form2" method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='section:edit' argument='?EDIT'}}{{else}}{{LINK script='panel' section='section:edit' argument='?EDIT'}}{{/if}}">
      <span>
        <select class="list" name="file" onchange="submit();" style="width:80%">
          <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_section_to_edit}}</option>
          {{section name="sections" loop=$SECTIONS}}
          <option value="{{$SECTIONS[sections].name}}">{{$SECTIONS[sections].name|replace:"_":"/"}} - {{$SECTIONS[sections].title}}</option>
		  {{/section}}
  
        </select>
		<input type="hidden" name="panel" value="1" />
      </span>
  </form>
  {{* To Delete sections, Sections must be 2 or more. Remember, 'home' can't be deleted 
  {{if count($SECTIONS) > 1}}
  <br />
  <form id="form3" method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='section:delete' argument='?DELETE'}}{{else}}{{LINK script='panel' section='section:delete' argument='?DELETE'}}">
    <span>
      <select class="list" name="filename"
  onchange="if(confirm('{{$LANG.delete_section_warn|ucfirst}}')) return submit()" style="width:80%">
        <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_section_to_delete}}</option>
        {{section name="sections" loop=$SECTIONS}}
		{{if $SECTIONS[sections].name != home}}<option value="{{$SECTIONS[sections].name}}">{{$SECTIONS[sections].name|replace:"_":"/"}} - {{$SECTIONS[sections].title}}</option>{{/if}}
		
		{{/section}}
      </select>
    </span>
  </form>
  {{/if}}*}}
  </div>
