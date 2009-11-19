{{if $smarty.session.loged_ok}}
<div class="message_ok">{{$LANG.loged_in_success}}</div>
{{elseif $smarty.session.not_loged_in}}
<div class="message_error">{{$LANG.incorrect_pass|ucfirst}}</div>
{{/if}}
