<p style="margin:3px 0 -2px 0;padding:3px 0;margin:3px 0 0 0;font-family:Verdana,Arial,sans-serif;font-size:14px">
<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/img/separator.gif" style="position:absolute;padding:5px 0 0 0;margin:0 0 0 -2px" />&nbsp;{{$LANG.title|ucfirst}}: 
  <input style="width:200px;margin:0;font-size:14px" class="mceSelectList" type="text" name="title" value="{{$TITLE}}{{if $TITLE == null && $smarty.get.title != null}}{{$smarty.get.title}}{{/if}}" /> 
  <label title="{{$LANG.indicates_exclusive|ucfirst}}">
  <input class="mceSelectList" name="exclusive" type="checkbox" value="1" {{if $EXCLUSIVE && !isset($smarty.get.NEW)}}checked="checked"{{/if}} /> 
  {{$LANG.exclusive|ucfirst}}
  </label> 
  <img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/images/separator.gif" style="position:absolute;padding:0 1px" />&nbsp;
  <a id="elm1_save" href="javascript:;">{{$LANG.save|ucfirst}}</a>&nbsp;<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/images/separator.gif" style="position:absolute;padding:0 1px" />&nbsp;
  {{if !isset($smarty.get.NEW)}}<a href="{{LINK section=$FILENAME argument='?section='}}" onclick="return confirm('{{$LANG.confirm_exit_editor|ucfirst}}');">{{$LANG.cancel|ucfirst}}</a>{{else}}<span title="{{$LANG.cant_cancel_title}}">{{$LANG.cant_cancel}}</span>{{/if}}
  </p>
</div>
	<p style="margin:0"><textarea id="elm1" name="content" rows="30" cols="80" style="width: 100%">
{{if !isset($smarty.get.NEW)}}{{fetch2 file=$FILE}}{{/if}}
	</textarea></p>
<p style="margin:0"><input type="hidden" name="file" value="{{$FILENAME}}" /></p>
<p style="margin:0"><input type="hidden" name="category" value="{{$CATEGORY}}" /></p>
</form>
</body>
</html>
