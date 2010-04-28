<div class="content">
<a name="content" title="{{$LANG.content}}"></a>
<h5 class="invisible">{{$LANG.content}}</h5>

<h1>{{$CATEGORY_TITLE}}</h1>

{{section name=menu loop=$ITEMS}}
<div style="float:center;margin:auto;width:500px;margin-bottom:10px">
<h3 style="margin:0"><a href="{{LINK section=$ITEMS[menu].name}}"><span>{{$ITEMS[menu].title}}</span></a></h3>
{{fetch2 file=$ITEMS[menu].filename truncate=200}}
</div>
{{sectionelse}}
<div>
<p style="text-align:center">{{$LANG.no_sections|ucfirst}}</p>
<p style="text-align:center"><a href="{{LINK section="home"}}">{{$LANG.return|ucfirst}}</a>
</div>
{{/section}}

</div>