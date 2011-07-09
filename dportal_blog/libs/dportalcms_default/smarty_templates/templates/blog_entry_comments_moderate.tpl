<h4>Comentarios sin moderar:</h4>
{{section name="comments" loop=$COMMENTS_ADMIN}}
		<div class="comment" style="border:1px black dotted;">
			<div style="float:left">{{$LANG.published_by|ucfirst}} <strong>{{if $COMMENTS[comments].website != null}}<a href="{{$COMMENTS[comments].website}}">{{/if}}{{$COMMENTS[comments].nick}}{{if $COMMENTS[comments].website != null}}</a>{{/if}}</strong>, {{$LANG.at}} {{$COMMENTS[comments].timestamp|date_format:"%m/%d/%y"}} {{$COMMENTS[comments].timestamp|date_format:"%H:%M:%S"}}{{*if $IS_ADMIN}} | {{$LANG.delete|ucfirst}}{{/if*}}</div>
			<div style="float:right">{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}<input name="comments[]" type="checkbox" value="{{else}}<span style="visibility:hidden">Timestamp: {{/if}}{{/DYNAMIC}}{{$COMMENTS[comments].timestamp}}{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}" />{{else}}</span>{{/if}}{{/DYNAMIC}}</div>
			<div style="clear:both"></div>
			<div style="margin:10px">{{$COMMENTS[comments].comment}}</div>
			{{cycle values=",,,,<div style=\"text-align:right\"><a href=\"#entry\">Top</a></div>"}}
		</div>
		<div style="clear:left;height:10px"></div>
{{/section}}

