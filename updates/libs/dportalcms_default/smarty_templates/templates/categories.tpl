<div class="content">
<a name="content" title="{{$LANG.content}}"></a>
<h5 class="invisible">{{$LANG.content}}</h5>

<h1>Categories on this site:</h1>

<div style="width:300px;float:center;margin:10px auto;">
<div style="min-width:48%;text-align:center;{{if $CATEGORIES != null}}display:inline-table{{/if}}">
<span><a href="{{LINK script="category"}}">{{$LANG.main|ucfirst}}</a></span>
</div>
{{section loop=$CATEGORIES name="item"}}
<div style="min-width:48%;text-align:center;display:inline-table">
<span><a href="{{LINK script="category" section=$CATEGORIES[item].name}}">{{$CATEGORIES[item].title}}</a></span>
</div>
{{/section}}
</div>

</div>