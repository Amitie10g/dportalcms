<hr />
<div id="comment">
{{if $smarty.session.nick_empty}}<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.nick_empty_warn}}</div>{{/if}}
{{if $smarty.session.email_empty}}<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.email_no_empty}}</div>{{/if}}
{{if $smarty.session.comment_empty}}<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.comment_empty_warn}}</div>{{/if}}
{{if $ALLOW_PUBLISH}}
	<h1>{{$LANG.post_comment|ucfirst}}</h1>

	<form method="post" action="{{LINK script='books' page='POST_COMMENT' argument='?POST_COMMENT'}}">

		<table style="width:100%;margin:0;padding:0">
			  {{if !$LOGED_IN}}<tr>
				<td style="text-align:right;font-weight:bold">{{$LANG.nick|ucfirst}}:</td>
				<td><input type="text" name="nick" style="width:60%;{{if $smarty.session.nick_empty}}background:#FF8888{{/if}}" value="{{$SAVED_NICK}}" />
				<span style="font-size:9px">{{$LANG.obligatory|ucfirst}}</span></td>
			  </tr>
			  <tr>
				<td style="text-align:right;font-weight:bold">Email: </td>
				<td><input type="text" name="email" style="width:60%;{{if $smarty.session.invalid_email}}background:#FF8888{{/if}}"  value="{{$SAVED_EMAIL}}" />
				<span style="font-size:9px">{{$LANG.obligatory_no_published}}</span></td>
			  </tr>
			  <tr>
				<td style="text-align:right;font-weight:bold;">URL:</td>
				<td><input type="text" name="url" style="width:60%;{{if $smarty.session.invalid_url}}background:#FF8888{{/if}}"  value="{{$SAVED_WEBSITE}}" />
				<span style="font-size:9px">{{$LANG.optional|ucfirst}}</span></td>
			  </tr>{{/if}}
			  <tr>
				<td colspan="2">{{$LANG.your_comments_max}}<br />
				<textarea name="comment" style="width:100%;height:200px;{{if $smarty.session.comment_empty}}border:#FF5555 3px inset{{/if}}" rows="10" cols="20">{{$smarty.session.comment}}</textarea></td>
			  </tr>
			  <tr>
				<td colspan="2" style="text-align:center">
				<input type="hidden" name="book" value="{{$BOOK}}" />
				<input type="hidden" name="chapter" value="{{$CHAPTER}}" />
				<input type="submit" style="font-size:18px;width:100px" value="{{$LANG.send|ucfirst}}" /></td>
			  </tr>
		</table>
	</form>
{{else}}
<p style="margin:20px;font-size:14px">{{$LANG.comment_already_published|ucfirst|replace:"TIME_LEFT":$TIME_LEFT}}</p>
{{/if}}
</div>

