{{* Comment:
	Include unconditionately this Template to Output, inclusive if
	AJAX is used. This will warrant than Comments will be displayed to
	Robots/Accessibility mode (when Javascript is disabled).
	This will be overriden by the AJAX comments.
	
	By default, will be displayed 5 comments per page,
	and 20 comments per page using AJAX.
*}}
<div style="text-align:center">
{{if $PAGE > 1}}
		
{{if $PREV == 1}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="book_comments_goto_ajax" argument=$smarty.get.book section=$smarty.get.chapter page='1'}}','getcomments');">{{else}}<a href="{{LINK script="chapter" page=$smarty.get.book section=$smarty.get.chapter marker='comments'}}" rel="nofollow">{{/if}}{{else}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="book_comments_goto_ajax" argument=$smarty.get.book section=$smarty.get.chapter page=$PREV marker="comments"}}','getcomments');">{{else}}<a href="{{LINK script="book_comments_goto" argument=$smarty.get.book section=$smarty.get.chapter page=$PREV marker="comments"}}" rel="nofollow">{{/if}}{{/if}}&#8810;&nbsp;Previous&nbsp;{{if $AJAX}}</span>{{else}}</a>{{/if}}{{/if}}
		
{{section name='pages' loop=$PAGES step=$IPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="book_comments_goto_ajax" argument=$smarty.get.book section=$smarty.get.chapter page='1'}}','getcomments');">{{else}}<a href="{{LINK script="chapter" page=$smarty.get.book section=$smarty.get.chapter marker='comments'}}" rel="nofollow">{{/if}}{{else}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="book_comments_goto_ajax" argument=$smarty.get.book section=$smarty.get.chapter page=$smarty.section.pages.iteration marker='comments'}}','getcomments');">{{else}}<a href="{{LINK script="book_comments_goto" argument=$smarty.get.book section=$smarty.get.chapter page=$smarty.section.pages.iteration marker='comments'}}" rel="nofollow">{{/if}}{{/if}}{{/if}}
&nbsp;{{$smarty.section.pages.iteration}}&nbsp;
{{if $smarty.section.pages.iteration != $PAGE}}{{if $AJAX}}</span>{{else}}</a>{{/if}}{{/if}}
{{/if}}
{{/section}}
		
{{if $PAGE < $smarty.section.pages.total}}{{if $AJAX}}<span style="cursor:pointer;font-weight:bold" onclick="callajax('{{LINK script="book_comments_goto_ajax" argument=$smarty.get.book section=$smarty.get.chapter page=$NEXT}}','getcomments');">{{else}}<a href="{{LINK script="book_comments_goto" argument=$smarty.get.book section=$smarty.get.chapter page=$NEXT marker="comments"}}" rel="nofollow">{{/if}}&nbsp;Next&nbsp;&#8811;{{if $AJAX}}</span>{{else}}</a>{{/if}}
{{/if}}
</div>


