<body{{CALLAJAX url=$AJAX_URL block=$AJAX_BLOCK}}{{POPUP type=$WARNING_MESSAGE.type message=$WARNING_MESSAGE.message}}>
<h5 class="invisible">{{if !LOGED_IN}}<a href="#login">{{$LANG.login|ucfirst}}</a> | {{/if}}<a href="#content" rel="nofollow">{{$LANG.jump_to_content|ucfirst}}</a>{{if $IS_ENTRY || $IS_BOOK}} | <a href="#comments" rel="nofollow">{{$LANG.jump_to_comments|ucfirst}}</a> | <a href="#comment" rel="nofollow">{{$LANG.jump_to_comment|ucfirst}}</a>{{/if}}</h5>

