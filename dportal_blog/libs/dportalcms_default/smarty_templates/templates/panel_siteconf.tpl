
<div style="width:600px;margin:auto;padding:10px 0">
  <form id="form1" method="post"
action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">
      <div style="text-align:right; margin: 0 10px 0 10px;float:left">
        <div> <strong>{{$LANG.sitename|ucfirst}}:</strong>
            <input type="text"
  name="sitename" value="{{$SITENAME}}" style="width:170px" />
        </div>
        <div> <strong>{{$LANG.sitedesc|ucfirst}}:</strong>
            <input type="text"
  name="sitedesc" value="{{$SITE_DESCRIPTION}}" style="width:170px" />
        </div>
      </div>
    <div style="text-align:right; margin: 0 20px 0 0;float:right">
        <div> <strong>{{$LANG.admin_email|ucfirst}}Admin email:</strong>
            <input type="text"
  name="admin_email" value="{{$ADMIN_EMAIL}}" style="width:170px" />
        </div>
      <div> <strong>{{$LANG.admin_nick|ucfirst}}Admin nick:</strong>
            <input type="text"
  name="admin_nick" value="{{$ADMIN_NICK}}" style="width:170px" />
      </div>
    </div>
	
	<div style="clear:both">&nbsp;</div>
		{{* Language support currently not available *}}
		{{*
	 	<div style="text-align:center">
        <select name="lang" style="width:90px"title="Select language (default, current)">
          <option value="{{$LANGFILES[0].key}}" selected="selected" disabled="disabled">Language</option>
          
		{{section name="lang" loop=$LANGFILES}}
          <option value="{{$LANGFILES[lang].key}}">{{$LANGFILES[lang].str}}</option>
          {{/section}}
        </select>
		*}}
		
          <label>
            <input type="checkbox" name="use_rewrite" value="1" {{if $USE_REWRITE}}checked="checked"{{/if}} />
            {{$LANG.use_canonical_url|ucfirst}} <strong></strong> (<strong>mod_rewrite</strong>)</label>
	<div style="clear:both">&nbsp;</div>
    <div style="text-align:center">
        <input name="submit" type="submit" value="    {{$LANG.save|ucfirst}}    " />
    </div>
	</div>
    </form>
	<div style="clear:both">&nbsp;</div>
</div>