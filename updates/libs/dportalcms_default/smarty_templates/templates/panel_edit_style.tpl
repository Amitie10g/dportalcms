<<<<<<< .mine
<div style="padding:5px">

</div>
=======
<div style="padding: 10px">{{$LANG.edit_style_warn}}</div>
<div style="padding: 10px;text-align:center">
  <form method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='style/UPDATE_STYLE' argument='?UPDATE_STYLE'}}{{else}}{{LINK script='panel' section='style/UPDATE_STYLE' argument='?UPDATE_STYLE'}}{{/if}}">

<table border="0" style="margin:auto">
{{foreach item='value' from=$STYLE_LIST key='key' name='style_list'}}
  <tr>
    <th style="text-align:right;width:auto">{{$LANG.$key}}:</th>
	
    
	<td style="text-align:left">{{if $value.type == 'color'}}
	#<input class="color" style="width:60px" type="text" name="style[{{$key}}]" value="{{$value.value}}" />
	
	{{elseif $value.type == 'bg'}}
	#<input class="color" style="width:60px" type="text" name="style[{{$key}}_color]" value="{{$value.value.color}}" />
	<input type="text" style="width:100px" name="style[{{$key}}_params]" value="{{$value.value.params}}" />
	url(<input type="text" style="width:150px" name="style[{{$key}}_url]" value="{{$value.value.url}}" />)

    {{elseif $value.type == 'border'}}
	#<input class="color" style="width:60px" type="text" name="style[{{$key}}_color]" value="{{$value.value.color}}" />
	
	<select name="style[{{$key}}_size]">
	<option selected="selected" disabled="disabled">Size</option>
	{{foreach from=$value.parameters item="item"}}
		<option value="{{$item}}" {{if $item == $value.value.size}}selected="selected"{{/if}}>{{$item}}px</option>
	{{/foreach}}
	</select>
	
	<select name="style[{{$key}}_type]">
	<option disabled="disabled">Type</option>
	{{foreach from=$BORDER_TYPES item="item"}}
		<option value="{{$item}}" {{if ($item == $value.value.type)}}selected="selected"{{/if}}>{{$item}}</option>
	{{/foreach}}
	</select>

	{{elseif $value.type == 'size'}}
	<select name="style[{{$key}}]">
	<option selected="selected" disabled="disabled">Size</option>
	{{foreach from=$value.parameters item="item"}}
		<option value="{{$item}}" {{if ($item == $value.value)}}selected="selected"{{/if}}>{{$item}}px</option>
	{{/foreach}}
	</select>

    {{elseif $value.type == 'width'}}
	<input type="text" style="width:50px" name="style[{{$key}}_width]" value="{{$value.value.width}}" />
	<select name="style[{{$key}}_mode]">
		<option{{if $value.value.mode == 'px'}} selected="selected"{{/if}} value="px">px</option>
		<option{{if $value.value.mode == '%'}} selected="selected"{{/if}} value="%">%</option>
		<option{{if $value.value.mode == 'auto'}} selected="selected"{{/if}} value="auto">auto</option>
		<option{{if $value.value.mode == '0'}} selected="selected"{{/if}} value="0">zero</option>
	</select>

    {{elseif $value.type == 'font'}}
	<input type="text" style="width:99%" name="style[{{$key}}]" value="{{$value.value}}" />

    {{elseif $value.type == 'float'}}
	<select name="style[{{$key}}]">
		<option{{if $value.value == 'left'}} selected="selected"{{/if}} value="left">Left</option>
		<option{{if $value.value == 'right'}} selected="selected"{{/if}} value="right">Right</option>
	</select>
	{{/if}}</tr>
	{{if $value.separator == true}}<tr><td colspan="1">&nbsp;</td></tr>{{/if}}
{{/foreach}}
</table>





{{*
<table border="0" style="width:400px;margin:auto">


{{if $value.type == 'color'}}
  <tr rowspan="3">
    <th style="text-align:right;vertical-align:top">{{$LANG.$key}}:</th>
    <td colspan="3" style="text-align:left">#<input class="color" style="width:50px" type="text" name="style[{{$key}}]" value="{{$value.value}}" /></td>
  </tr>
{{elseif $value.type == 'bg'}}	
  <tr>
  	<th style="text-align:right;vertical-align:top">{{$LANG.$key}}:</th>
	<td style="text-align:left">#<input class="color" style="width:50px" type="text" name="style[{{$key}}][color]" value="{{$value.value.color}}" /></td>
  </tr>
  <tr>
    <th></th>
	<td style="text-align:left">url(<input type="text" style="width:70%"  name="style[{{$key}}][url]" value="{{$value.value.url}}" />)</td>
  </tr>
  <tr>
    <th></th>
	<td style="text-align:left"><input type="text" style="width:70%"  name="style[{{$key}}][params]" value="{{$value.value.params}}" /></td>
  </tr>
{{elseif $value.type == 'border'}}	
  <tr>
  	<th style="text-align:right;vertical-align:top">{{$LANG.$key}}:</th>
	<td style="text-align:left">#<input class="color" style="width:50px" type="text" name="style[{{$key}}][color]" value="{{$value.value.color}}" /></td>
  </tr>
  <tr>
    <th></th>
	<td style="text-align:left">
	<select name="style[{{$key}}][size]">
	<option selected="selected" disabled="disabled">Border</option>
	{{foreach from=$value.parameters item="value"}}
		<option value="{{$value}}">{{$value}}px</option>
	{{/foreach}}
	</select>
	</td>
  </tr>
  <tr>
    <th></th>
	<td style="text-align:left"><input type="text" style="width:70%"  name="style[{{$key}}][type]" value="{{$value.value.type}}" /></td>
  </tr>
  
  
  {{/if}}
  {{/foreach}}
</table>
*}}

	<div style="clear_both"><input type="submit" value="   {{$LANG.save|ucfirst}}   " /></div>
</form>
</div>
>>>>>>> .r184
