{{include file="blog_comments_goto.tpl"}}

{{* A Dirty-solution to use Dynamic data with Caching. remember, Values of variables vanishes when template is cached, and I'm opening and closing few times dynamic blogs. Only little problem, is the ID is displayed, but is hidden for graphical browsers *}}
		{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}<form method="post" action="{{LINK script="blog_delete_comments"}}">{{/if}}{{/DYNAMIC}}

		<div>
		{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}<div><input type="hidden" name="entry" value="{{else}}<span style="visibility:hidden">ID: {{/if}}{{/DYNAMIC}}{{$ID}}{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}" /></div>{{else}}</span>{{/if}}

		{{if $IS_ADMIN && $COMMENTS != false}}<div><input type="hidden" name="name" value="{{else}}<span style="visibility:hidden">Name: {{/if}}{{/DYNAMIC}}{{$NAME}}{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}" /></div>{{else}}</span>{{/if}}{{/DYNAMIC}}
		
		</div>

{{section name="comments" loop=$COMMENTS max=$CPP start=$START}}
{{if $COMMENTS[comments].moderate !== true}}
		<div class="comment" style="border:1px black dotted;">
			<div style="float:left">{{$LANG.published_by|ucfirst}} <strong>{{if $COMMENTS[comments].website != null}}<a href="{{$COMMENTS[comments].website}}">{{/if}}{{$COMMENTS[comments].nick}}{{if $COMMENTS[comments].website != null}}</a>{{/if}}</strong>, {{$LANG.at}} {{$COMMENTS[comments].timestamp|date_format:"%m/%d/%y"}} {{$COMMENTS[comments].timestamp|date_format:"%H:%M:%S"}}{{*if $IS_ADMIN}} | {{$LANG.delete|ucfirst}}{{/if*}}</div>
			<div style="float:right">{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}<input name="comments[]" type="checkbox" value="{{else}}<span style="visibility:hidden">Timestamp: {{/if}}{{/DYNAMIC}}{{$COMMENTS[comments].timestamp}}{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}" />{{else}}</span>{{/if}}{{/DYNAMIC}}</div>
			<div style="clear:both"></div>
			<div style="margin:10px">{{$COMMENTS[comments].comment}}</div>
			{{cycle values=",,,,<div style=\"text-align:right\"><a href=\"#entry\">Top</a></div>"}}
		</div>
		<div style="clear:left;height:10px"></div>
{{/if}}
		{{sectionelse}}<div style="font-style:italic;text-align:center">{{$LANG.no_comments_published|ucfirst}}</div>
{{/section}}
		{{DYNAMIC}}{{if $IS_ADMIN && $COMMENTS != false}}<div style="text-align:center"><input type="submit" value="    {{$LANG.delete_comments}}Delete comments    " /></div>
		</form>{{/if}}{{/DYNAMIC}}

{{include file="blog_comments_goto.tpl"}}

