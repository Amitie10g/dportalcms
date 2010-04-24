{{if $ENTRIES != null}}<div style="width:99%;margin:5px 72px 10px 0;text-align:center;">
{{if $PAGE > 1}}{{if $PREV == 1}}<a href="{{LINK script="blog"}}">{{else}}<a href="{{LINK script="blog_goto" section=$PREV}}">{{/if}}≪ {{$LANG.previous|ucfirst}}</a>&nbsp;{{/if}}
{{section name='pages' loop=$ENTRIES step=$EPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}<a href="{{LINK script="blog"}}">{{else}}<a href="{{LINK script="blog_goto" section=$smarty.section.pages.iteration}}">{{/if}}{{/if}}
{{$smarty.section.pages.iteration}}
{{if $smarty.section.pages.iteration != $PAGE}}</a>{{/if}}
{{/if}}
{{/section}}
{{if $PAGE < $smarty.section.pages.total}}<a href="{{LINK script="blog_goto" section=$NEXT}}">&nbsp;{{$LANG.next|ucfirst}}&nbsp;≫</a>{{/if}}
</div>{{/if}}
