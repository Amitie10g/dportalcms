<hr />
<div id="comments">
	<h2 style="text-align:center">{{$LANG.comments|ucfirst}}</h2>
	
	{{if $smarty.session.COMMENT_PUBLISHED}}
	<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{if $IS_ADMIN}}{{$LANG.comment_published|ucfirst}}{{else}}{{$LANG.comment_sended_moderate|ucfirst}}</span><br />{{$LANG.comment_will_be_moderated|ucfirst}}{{/if}}</div>
	{{elseif $smarty.session.COMMENT_NOT_PUBLISHED}}
	<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comment_error|ucfirst}}</div>
	{{elseif $smarty.session.COMMENTS_MODERATED}}
	<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{if $IS_ADMIN}}{{$LANG.comments_moderated|ucfirst}}{{else}}{{$LANG.comment_sended_moderate|ucfirst}}.</span><br />{{$LANG.comment_will_be_moderated|ucfirst}}.{{/if}}</div>
	{{elseif $smarty.session.COMMENTS_DELETED}}
	<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{if $IS_ADMIN}}{{$LANG.comments_deleted|ucfirst}}{{else}}{{$LANG.comment_sended_moderate|ucfirst}}.</span><br />{{$LANG.comment_will_be_moderated|ucfirst}}.{{/if}}</div>
	{{/if}}

	{{if !empty($smarty.session.COMMENT_PREVIEW_CONTENT) && !$LOGED_IN}}
	<div class="comment" style="border:1px black dotted;background:#FFEEAA;">
	<div>{{$LANG.published_by|ucfirst}} <strong>{{if $smarty.session.COMMENT_PREVIEW_URL != null}}<a href="{{$smarty.session.COMMENT_PREVIEW_URL}}">{{/if}}{{$smarty.session.COMMENT_PREVIEW_NICK}}{{if $smarty.session.COMMENT_PREVIEW_URL != null}}</a>{{/if}}</strong> (preview)</div>
	<div style="clear:left"></div>
	<div style="margin:10px">{{$smarty.session.COMMENT_PREVIEW_CONTENT}}</div>
	</div>
	<div style="clear:left;height:10px"></div>
	{{/if}}

	<div id="getcomments">
	<script type="text/javascript">//<![CDATA[
	document.write('<h2 style="text-align:center">{{$LANG.loading|ucfirst}}...</h2>')
	//]]></script>
	<noscript>{{include file="chapter_comments_c.tpl}}
	</noscript>
	</div>
</div>

