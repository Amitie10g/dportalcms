{{* Comment:
	Including unconditionately this Template to Output, inclusive if
	AJAX is used, this will warrant than Comments will be displayed to
	Robots/Accessibility mode. This will be overriden by the AJAX comments.
	
	By default, will be displayed 5 comments per page,
	and 10 comments per page using AJAX.
*}}
<div style="text-align:center">
{{if $PAGE > 1}}
		
{{if $PREV == 1}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="blog_comments_goto_ajax" section=$NAME page="1"}}','getcomments');">{{else}}<a href="{{LINK script="blog_entry" section=$NAME marker="comments"}}" rel="nofollow">{{/if}}{{else}}{{if $AJAX}}<span style="cursor:pointer" onclick="callajax('{{LINK script="blog_comments_goto_ajax" section=$NAME  page=$PREV}}','getcomments');">{{else}}<a href="{{LINK script="blog_comments_goto" section=$NAME  page=$PREV marker="comments"}}" rel="nofollow">{{/if}}{{/if}}&#8810;&nbsp;Previous&nbsp;{{if $AJAX}}</span>{{else}}</a>{{/if}}{{/if}}
		
{{section name='pages' loop=$COMMENTS step=$CPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="blog_comments_goto_ajax" page="1" section=$NAME}}','getcomments');">{{else}}<a href="{{LINK script="blog_entry" section=$NAME marker="comments"}}" rel="nofollow">{{/if}}{{else}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="blog_comments_goto_ajax" section=$NAME page=$smarty.section.pages.iteration}}','getcomments');">{{else}}<a href="{{LINK script="blog_comments_goto" section=$NAME page=$smarty.section.pages.iteration marker="comments"}}" rel="nofollow">{{/if}}{{/if}}{{/if}}
&nbsp;{{$smarty.section.pages.iteration}}&nbsp;
{{if $smarty.section.pages.iteration != $PAGE}}{{if $AJAX}}</span>{{else}}</a>{{/if}}{{/if}}
{{/if}}
{{/section}}
{{if $PAGE < $smarty.section.pages.total}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="blog_comments_goto_ajax" section=$NAME page=$NEXT}}','getcomments');">{{else}}<a href="{{LINK script="blog_comments_goto" section=$NAME page=$NEXT marker="comments"}}" rel="nofollow">{{/if}}&nbsp;Next&nbsp;&#8811;{{if $AJAX}}</span>{{else}}</a>{{/if}}
		
{{/if}}
</div>

