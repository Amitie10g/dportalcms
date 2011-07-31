<div style="text-align:center">
<form method="post" action="{{$link script="blog" section="tag" argument="tag"}}">
<h3 style="font-size:12px;margin:0">{{$LANG.find_by_tag}}</h3>
<input type="text" name="tag" style="width:85%" />
<input type="submit" />
</form>
{{foreach name="tags" key="tag" item="value" from=$CLOUDTAGS}}
<a href="{{LINK script="blog" section="tag:$tag"}}" style="font-size:{{$value}}%" rel="nofollow">{{$tag}}</a>&nbsp;
{{/foreach}}
</div>
<hr />
