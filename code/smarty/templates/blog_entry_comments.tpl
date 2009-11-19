{{include file="blog_comments_goto.tpl"}}

		{{section name="comments" loop=$COMMENTS max=$CPP start=$START}}
		<div class="comment" style="border:1px black dotted;">
			<div>{{$LANG.published_by|ucfirst}} <strong>{{if $COMMENTS[comments].website != null}}<a href="{{$COMMENTS[comments].website}}">{{/if}}{{$COMMENTS[comments].nick}}{{if $COMMENTS[comments].website != null}}</a>{{/if}}</strong>, {{$LANG.at}} {{$COMMENTS[comments].timestamp|date_format:"%m/%d/%y"}} 
			{{$COMMENTS[comments].timestamp|date_format:"%H:%M:%S"}}{{*if $IS_ADMIN}} | {{$LANG.delete|ucfirst}}{{/if*}}</div>
			<div style="margin:10px">{{$COMMENTS[comments].comment}}</div>
			{{cycle values=",,,,<div style=\"text-align:right\"><a href=\"#entry\">Top</a></div>"}}
		</div>
		<div style="clear:left;height:10px"></div>
		{{sectionelse}}<div style="font-style:italic;text-align:center">{{$LANG.no_comments_published|ucfirst}}</div>
		{{/section}}

{{include file="blog_comments_goto.tpl"}}
