<div class="content">
<h1 style="margin-bottom:10px">{{$LANG.playlists|ucfirst|default:Videos}}</h1>

<div style="width:500px;margin:5px auto 10px auto;text-align:center">
{{section name="pages" loop=$SHOWCASE step=$PPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}<a href="{{LINK script="showcase_goto" section=$smarty.section.pages.iteration}}">{{/if}}
{{$smarty.section.pages.iteration}}
{{if $smarty.section.pages.iteration != $PAGE}}</a>{{/if}}
{{/if}}
{{/section}}
{{if $PAGE > 1}}<a href="{{LINK script="showcase_goto" section=$PREV}}">Previous</a>&nbsp;{{/if}}{{if $PAGE < $smarty.section.pages.total}}<a href="{{LINK script="showcase_goto" section=$NEXT page=$smarty.get.playlist}}">Next</a>{{/if}}
</div>

{{section name='list' loop=$SHOWCASE max=$PPP start=$START}}
<div style="width:400px;float:center;margin:auto;border:#000000 1px dotted">
	<div style="float:left;width:110px">
		<a href="{{LINK section=$SHOWCASE[list].dirname script="playlist"}}"><img src="{{LINK section=$SHOWCASE[list].img script='video_thumb' page=$SHOWCASE[list].dirname}}" alt="Video" title="{{$SHOWCASE[list].title}}" style="width:100px;height:75px" /></a>
	</div>
	<div style="float:right:width:300px">
		<h3 style="margin:2px 0 7px 0"><a href="{{LINK section=$SHOWCASE[list].dirname script='playlist'}}" title="{{$SHOWCASE[list].title}}">{{$SHOWCASE[list].title}}</a></h3>
		<div style="margin:2px 0 7px 0">{{$SHOWCASE[list].numfiles}} video{{if $SHOWCASE[list].numfiles > 1}}s{{/if}}, {{$SHOWCASE[list].dirsize|default:0}} MiB.</div>
	</div>
	<div style="clear:left"></div>
</div>
<div style="clear:left">&nbsp;</div>
{{sectionelse}}<div>{{$LANG.no_videos|ucfirst|default:'No videos'}}</div>
{{/section}}
</div>
