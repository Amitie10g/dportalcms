		</div>
		<div style="margin:10px 0">
		<a href="#comment">{{$LANG.publish_comment|ucfirst}} </a> | 
		<a href="{{LINK script='blog'}}">{{$LANG.return|ucfirst}}</a>
		</div>
		</div>
		
		<div id="comments" style="border-bottom:1px black dotted">

		<div class="blog_commens">
		<h3 style="text-align:center">{{$LANG.comments|ucfirst}}</h3>

		{{if $smarty.session.COMMENT_PUBLISHED}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{if $IS_ADMIN}}{{$LANG.comment_published|ucfirst}}{{else}}{{$LANG.comment_sended_moderate|ucfirst}}{{/if}}</div>
		{{elseif $smarty.session.COMMENT_NOT_PUBLISHED}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comment_error|ucfirst}}</div>
		{{elseif $smarty.session.COMMENTS_MODERATED}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comments_moderated|ucfirst}}</div>
		{{elseif $smarty.session.COMMENTS_DELETED}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comments_deleted|ucfirst}}</div>
		{{elseif $smarty.session.COMMENTS_NOT_MODERATED}}
		<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comment_not_moderated|ucfirst}}</div>
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
		<noscript>
		{{* Bellow 'blog_entry_comments_c.tpl' that is CACHED! *}}

