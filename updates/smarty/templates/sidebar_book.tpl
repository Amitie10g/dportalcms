<div><h2 style="margin:0;font-size: 14px;text-align:center">Find author:</h2></div>
<form method="post" action={{LINK script="books" page="GOTO" argument="GOTO"}}>
	<input type="text" name="author" style="width:97%;margin:0" onclick="javascript:this.value=''" />
</form>

{{if $BOOKS != false}}
<div style="text-align:center">
{{if $IS_CHAPTER}}
<span style="font-size:15px">{{if $LOGED_IN}}<a href="{{LINK script='chapter_pdf' section=$CHAPTER  page=$BOOK}}" rel="nofollow" title="{{$LANG.pdf_version|ucfirst}}"><img src="http://{{$smarty.server.SERVER_NAME}}/{{$smarty.const.DPORTAL_PATH}}/images/application-pdf.png" alt="PDF"/>&nbsp;PDF</a>&nbsp;{{/if}}
<a href="{{LINK script='chapter_print' section=$CHAPTER  page=$BOOK}}" rel="nofollow" title="{{$LANG.printable_version|ucfirst}}"><img src="http://{{$smarty.server.SERVER_NAME}}/{{$smarty.const.DPORTAL_PATH}}/images/printer.png" alt="Print" />&nbsp;{{$LANG.print|ucfirst}}</a></span><br />
<span><a href="#comments" rel="nofollow">{{$LANG.comments|ucfirst}}</a></span><br />
<span><a href="#comment" rel="nofollow">{{$LANG.post_comment|ucfirst}}</a></span><br />
{{/if}}
<form method="post" action="{{LINK script='books' page='GOTO' argument="?GOTO"}}">
<p><select name="book" style="width:120px" onchange="submit()">
<option selected="selected" disabled="disabled">{{$LANG.select_book|ucfirst}}</option>
{{section name=books loop=$BOOKS}}
<option value="{{$BOOKS[books].name}}">{{$BOOKS[books].title}}</option>
{{/section}}
</select>
<input type="submit" value="{{$LANG.go}}" style="width:120px" />
</p>
</form>

{{if $CHAPTERS != null && count($CHAPTERS) > 1}}<form method="post" action="{{LINK script='books' page='GOTO' argument="?GOTO"}}">
<p><input type="hidden" name="book" value="{{$BOOK}}" />
<select name="chapter" style="width:120px" onchange="submit()">
<option selected="selected" disabled="disabled">{{$LANG.select_chapter|ucfirst}}</option>
{{section name=chapters loop=$CHAPTERS}}
<option value="{{$CHAPTERS[chapters].name}}">{{$CHAPTERS[chapters].title}}</option>
{{/section}}
</select>
<input type="submit" value="{{$LANG.go}}" style="width:120px" />
</p>
</form>{{/if}}

</div>
{{/if}}
<hr />
