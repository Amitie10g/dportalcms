<h1>{{$TITLE}}</h1>

{{DYNAMIC}}
{{if $smarty.session.CHAPTER_UPDATED}}
<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.chapter_updated|ucfirst}}.</div>
{{elseif $smarty.session.CHAPTER_NOT_SAVED}}
<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.chapter_not_updated|ucfirst}}.</div>
{{/if}}

{{/DYNAMIC}}
{{fetch2 file=$FILENAME_FULL}}
{{DYNAMIC}}
<div><p style="text-align:center;font-style:italic">{{$LICENSE}}</p></div>

{{if isset($smarty.get.PRINT)}}
<div class="no_print">
<hr />
<a href="{{LINK script='chapter' page=$BOOK section=$CHAPTER}}">{{$LANG.return|ucfirst}}</a>{{if $LOGED_IN}} | 
<a href="{{LINK script='chapter_pdf' page=$BOOK section=$CHAPTER}}">PDF version</a>{{/if}}{{/if}}

{{/DYNAMIC}}

