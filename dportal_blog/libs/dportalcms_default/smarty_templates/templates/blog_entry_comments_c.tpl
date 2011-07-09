
{{include file="blog_comments_goto.tpl"}}

{{if $IS_ADMIN && $COMMENTS !== false}}<form method="post" action="{{LINK script="blog_delete_comments"}}">

<div><input type="hidden" name="entry" value="{{$ID}}" /></div>{{/if}}

{{section name="comments" loop=$COMMENTS max=$CPP start=$START}}
		<div class="comment" style="border:1px black dotted;{{if $COMMENTS[comments].moderate == 1}}background:#FFEEEE;{{elseif $COMMENTS[comments].moderate == 2}}background:#EEEEFF;{{/if}}">
			<div><label>{{if $IS_ADMIN && $COMMENTS !== false}}<input type="checkbox" name="comments[]" value="{{$COMMENTS[comments].timestamp}}" />{{/if}}{{$LANG.published_by|ucfirst}} <strong>{{if $COMMENTS[comments].website != null}}<a href="{{$COMMENTS[comments].website}}">{{/if}}{{$COMMENTS[comments].nick}}{{if $COMMENTS[comments].website != null}}</a>{{/if}}</strong>, {{$LANG.at}} {{$COMMENTS[comments].timestamp|date_format:"%m/%d/%Y"}} {{$COMMENTS[comments].timestamp|date_format:"%H:%M:%S"}}{{if $COMMENTS[comments].moderate == 1}} {{$LANG.non_moderated}}{{/if}}{{if $IS_ADMIN && $COMMENTS !== false}} - <span style="font-weight:bold">{{$LANG.ip_address}}:</span> {{$COMMENTS[comments].ip}}{{/if}}</label></div>
			<div style="clear:left"></div>
			<div style="margin:10px">{{$COMMENTS[comments].comment}}</div>
			{{cycle values=",,,,<div style=\"text-align:right\"><a href=\"#content\">Top</a></div>"}}
		</div>
		<div style="clear:left;height:10px"></div>
		{{sectionelse}}<div style="font-style:italic;text-align:center">{{$LANG.no_comments_published|ucfirst}}</div>
{{/section}}

		{{if $IS_ADMIN && $COMMENTS !== false}}<div style="float:left;position:absolute">
		<select name="action" onchange="submit()">
			<option selected="selected" disabled="disabled">{{$LANG.select_action|ucfirst}}</option>
			<option value="1">{{$LANG.moderate_comments|ucfirst}}</option>
			<option value="0">{{$LANG.delete_comments|ucfirst}}</option>
		</select>
		<input type="submit" value="{{$LANG.go}}">
		</div>
	</form>{{/if}}

{{include file="blog_comments_goto.tpl"}}
<div style="clear:left;{{if $IS_ADMIN && $COMMENTS !== false}}margin:40px 0{{/if}}"></div>

