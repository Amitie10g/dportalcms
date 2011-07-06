<div style="padding: 10px">{{$LANG.edit_style_warn}}</div>
<div style="padding: 10px;text-align:center">
  <form method="post" action="{{LINK script='panel' section='UPDATE_STYLE' argument='?UPDATE_STYLE'}}">

	<div style="min-width:200px;max-width:380px;margin:auto;">
  	{{foreach item='value' from=$STYLE_LIST key='key' name='style_list'}}
	<div style="clear_both">
      <div style="text-align:right;"><strong>{{$LANG.$key}}:</strong>&nbsp;
        <input type="text" name="style[{{$key}}]" value="{{$value.value}}" /></div>
	  <div style="clear_both">&nbsp;</div>
	</div>
	{{/foreach}}
	<div style="clear_both"><input type="submit" value="   {{$LANG.save}}   " /></div>
	</div>
  </form>
</div>
