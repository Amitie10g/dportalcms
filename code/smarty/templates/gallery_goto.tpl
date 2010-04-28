{{if $IMAGELIST != null}}<div style="width:99%;margin:5px 72px 10px 0;text-align:center;">
{{if $PAGE > 1}}{{if $PREV == 1}}<span style="cursor:pointer" onclick="callajax('{{LINK script="gallery_ajax" section=$smarty.get.gallery}}','gallery_content');">{{else}}<span style="cursor:pointer" onclick="callajax('{{LINK script="gallery_ajax_goto" section=$smarty.get.gallery page=$PREV}}','gallery_content');">{{/if}}≪ {{$LANG.previous|ucfirst}}&nbsp;</span>&nbsp;{{/if}}
{{section name='pages' loop=$IMAGELIST step=$IPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}<span style="cursor:pointer;color:#000000" onclick="callajax('{{LINK script="gallery_ajax" section=$smarty.get.gallery}}','gallery_content');">{{else}}<span style="cursor:pointer;color:#000000" onclick="callajax('{{LINK script="gallery_ajax_goto" section=$smarty.get.gallery page=$smarty.section.pages.iteration}}','gallery_content');">{{/if}}{{else}}<span style="color:#555555">{{/if}}&nbsp;{{$smarty.section.pages.iteration}}&nbsp;</span>{{/if}}
{{/section}}
{{if $PAGE < $smarty.section.pages.total}}<span style="cursor:pointer" onclick="callajax('{{LINK script="gallery_ajax_goto" section=$smarty.get.gallery page=$NEXT}}','gallery_content');">&nbsp;{{$LANG.next|ucfirst}} ≫&nbsp;</span>{{/if}}
</div>{{/if}}

