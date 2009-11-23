		<a name="comment"></a>
		<h3 style="text-align:center">{{$LANG.publish_comment|ucfirst}}</h3>
		<div class="blog_comment" style="width:500px;float:center;margin:auto">
			<form method="post" action="{{LINK script='blog' page='POST_COMMENT' argument='?POST_COMMENT'}}">
			<table style="width:100%;margin:0;padding:0">
			  <tr>
				<td style="text-align:right;font-weight:bold">{{$LANG.nick|ucfirst}}:</td>
				<td><input type="text" name="nick" style="width:60%;{{if $smarty.session.nick_empty}}background:#FF8888{{/if}}" value="{{$smarty.session.nick}}" />
				<span style="font-size:9px">{{$LANG.obligatory|ucfirst}}</span></td>
			  </tr>
			  <tr>
				<td style="text-align:right;font-weight:bold">Email: </td>
				<td><input type="text" name="email" style="width:60%;{{if $smarty.session.invalid_email}}background:#FF8888{{/if}}"  value="{{$smarty.session.email}}" />
				<span style="font-size:9px">{{$LANG.obligatory_no_published}}</span></td>
			  </tr>
			  <tr>
				<td style="text-align:right;font-weight:bold;">URL:</td>
				<td><input type="text" name="url" style="width:60%;{{if $smarty.session.invalid_url}}background:#FF8888{{/if}}"  value="{{$smarty.session.url}}" />
				  <span style="font-size:9px">{{$LANG.optional|ucfirst}}</span></td>
			  </tr>
			  <tr>
				<td colspan="2">{{$LANG.your_comments_max}}<br />
				<textarea name="comment" style="width:100%;height:200px;{{if $smarty.session.comment_empty}}border:#FF5555 3px inset{{/if}}" rows="10" cols="20", maxlength="10"></textarea></td>
				</tr>
			  <tr>
				<td colspan="2" style="text-align:center">
				<input type="hidden" name="id" value="{{$ID}}" />
				<input type="hidden" name="name" value="{{$NAME}}" />
				<input type="submit" style="font-size:18px;width:100px" value="{{$LANG.send|ucfirst}}" /></td>
				</tr>
			</table>
				</form>
		</div>
