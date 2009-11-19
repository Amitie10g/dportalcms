<div style=";margin:2px 72px 10px 0;text-align:center;">
{{if $PAGE > 1}}{{if $PREV == 1}}<a href="{{LINK script="blog_entry" section=$NAME}}">{{else}}<a href="{{LINK script="blog_comments_goto" section=$NAME  page=$PREV}}">{{/if}}≪&nbsp;Previous&nbsp;</a>&nbsp;{{/if}}
{{section name='pages' loop=$COMMENTS step=$CPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}<a href="{{LINK script="blog_entry" section=$NAME}}">{{else}}<a href="{{LINK script="blog_comments_goto" section=$NAME page=$smarty.section.pages.iteration}}">{{/if}}{{/if}}
&nbsp;{{$smarty.section.pages.iteration}}&nbsp;
{{if $smarty.section.pages.iteration != $PAGE}}</a>{{/if}}
{{/if}}
{{/section}}
{{if $PAGE < $smarty.section.pages.total}}<a href="{{LINK script="blog_comments_goto" section=$NAME page=$NEXT}}">&nbsp;Next&nbsp;≫</a>{{/if}}
</div>

