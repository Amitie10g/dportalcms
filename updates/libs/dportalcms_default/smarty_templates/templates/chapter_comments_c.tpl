{{include file="chapter_comments_goto.tpl"}}

{{if $ALLOWED_EDIT && $COMMENTS !== false}}<form method="post" action="{{LINK script='books' page='MODERATE_COMMENTS' argument='?MODERATE_COMMENTS'}}">
<p><input type="hidden" name="book" value="{{$BOOK}}" />
<input type="hidden" name="chapter" value="{{$CHAPTER}}" /></p>
{{/if}}
{{section name="comments" loop=$COMMENTS max=$MAX start=$START}}
		<div class="comment" style="border:1px black dotted;{{if $COMMENTS[comments].moderate == 1}}background:#FFEEEE;{{elseif $COMMENTS[comments].moderate == 2}}background:#EEEEFF;{{elseif $COMMENTS[comments].moderate == 3}}background:#EEFFEE;{{/if}}">
			<div style="float:left">
			{{if $ALLOWED_EDIT && $COMMENTS !== false}}<label><input type="checkbox" name="id[]" value="{{$COMMENTS[comments].id}}" />{{/if}}{{$LANG.published_by|ucfirst}} <strong>{{if $COMMENTS[comments].url != null}}<a href="{{$COMMENTS[comments].url}}">{{elseif $COMMENTS[comments].moderate == 2 || $COMMENTS[comments].moderate == 3}}<a href="{{$smarty.const.PHPBB_URL_PATH}}memberlist.php?mode=viewprofile&u={{$COMMENTS[comments].nick|get_id_by_user}}">{{/if}}{{$COMMENTS[comments].nick}}{{if $COMMENTS[comments].url != null || $COMMENTS[comments].moderate == 2 || $COMMENTS[comments].moderate == 3}}</a>{{/if}}{{if $COMMENTS[comments].moderate == 2}} ({{$LANG.administrator|ucfirst}}){{elseif $COMMENTS[comments].moderate == 3}} ({{$LANG.owner}}){{/if}}</strong>, {{$LANG.at}} {{$COMMENTS[comments].timestamp|date_format:"%m/%d/%y"}} {{$COMMENTS[comments].timestamp|date_format:"%H:%M:%S"}}{{if $COMMENTS[comments].moderate == 1}} {{$LANG.non_moderated|ucfirst}}{{/if}}{{if $IS_ADMIN && $COMMENTS !== false}} - <span style="font-weight:bold">{{$LANG.ip_address}}:</span> {{$COMMENTS[comments].ip}}</label>{{/if}}</div>
			<div style="clear:left"></div>
			<div style="margin:10px">{{$COMMENTS[comments].comment}}</div>
			{{cycle values=",,,,<div style=\"text-align:right\"><a href=\"#content\">Top</a></div>"}}
		</div>
		<div style="clear:left;height:10px"></div>
		{{sectionelse}}<div style="font-style:italic;text-align:center">{{$LANG.no_comments_published|ucfirst}}</div>
{{/section}}
{{if $ALLOWED_EDIT && $COMMENTS !== false}}<div{{if $PAGES > 1}} style="position:absolute"{{/if}}>
		<select name="action" onchange="submit()">
			<option selected="selected" disabled="disabled">{{$LANG.select_action|ucfirst}}</option>
			<option value="1">{{$LANG.moderate_comments|ucfirst}}</option>
			<option value="0">{{$LANG.delete_comments|ucfirst}}</option>
		</select>
		<input type="submit" value="{{$LANG.go}}" />
		</div>
	</form>
{{/if}}
	
{{include file="chapter_comments_goto.tpl"}}
<div style="clear:left;">&nbsp;</div>	

