{{if $ENTRIES != null}}{{if count($ENTRIES) > $EPP}}<div style="width:99%;margin:10px 0;text-align:center;">{{/if}}
{{if $PAGE > 1}}{{if $PREV == 1}}<a href="{{if !empty($YEAR) && empty($MONTH)}}{{LINK script="blog" section="$YEAR/" argument="&amp;year=$YEAR"}}{{elseif !empty($YEAR) && !empty($MONTH)}}{{LINK script="blog" section="$YEAR/$MONTH/" argument="&amp;year=$YEAR&amp;month=$MONTH"}}{{else}}{{LINK script="blog"}}{{/if}}">{{else}}<a href="{{if !empty($YEAR) && empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/" argument="&amp;year=$YEAR" page=$PREV}}{{elseif !empty($YEAR) && !empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/$MONTH/" argument="&amp;year=$YEAR&amp;month=$MONTH" page=$PREV}}{{else}}{{LINK script="blog_goto" page=$PREV}}{{/if}}">{{/if}}&#8810;&nbsp;{{$LANG.previous|ucfirst}}</a>&nbsp;{{/if}}
{{section name='pages' loop=$ENTRIES step=$EPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}{{if $smarty.section.pages.iteration == 1}}<a href="{{LINK script="blog"}}">{{else}}<a href="{{if !empty($YEAR) && empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/" argument="&amp;year=$YEAR" page=$smarty.section.pages.iteration}}{{elseif !empty($YEAR) && !empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/$MONTH/" argument="&amp;year=$YEAR&amp;month=$MONTH" page=$smarty.section.pages.iteration}}{{else}}{{LINK script="blog_goto" page=$smarty.section.pages.iteration}}{{/if}}">{{/if}}{{/if}}
&nbsp;{{$smarty.section.pages.iteration}}&nbsp;
{{if $smarty.section.pages.iteration != $PAGE}}</a>{{/if}}
{{/if}}
{{/section}}
{{if $PAGE < $smarty.section.pages.total}}<a href="{{if !empty($YEAR) && empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/" argument="&amp;year=$YEAR" page=$NEXT}}{{elseif !empty($YEAR) && !empty($MONTH)}}{{LINK script="blog_goto" section="$YEAR/$MONTH/" argument="&amp;year=$YEAR&amp;month=$MONTH" page=$NEXT}}{{else}}{{LINK script="blog_goto" page=$NEXT}}{{/if}}">&nbsp;{{$LANG.next|ucfirst}}&nbsp;&#8811;</a>{{/if}}
{{if $ENTRIES != null}}{{if count($ENTRIES) > $EPP}}</div>{{/if}}{{/if}}{{/if}}
