<a name="content" id="content"></a>
<div class="content"{{if $HQ}} style="width:97.5% !important"{{/if}}>
<h5 class="invisible">Content</h5>
<h1 style="margin: 0 0 10px 0">{{$TITLE}}</h1>
<div style="width:500px;margin:5px auto 10px auto;text-align:center">
{{section name="pages" loop=$PLAYLIST step=$VPP}}
{{if $smarty.section.pages.total != 1}}
{{if $smarty.section.pages.iteration != $PAGE}}<a href="{{LINK script="playlist_goto" section=$smarty.section.pages.iteration page=$smarty.get.playlist}}">{{/if}}
{{$smarty.section.pages.iteration}}
{{if $smarty.section.pages.iteration != $PAGE}}</a>{{/if}}
{{/if}}
{{/section}}
{{if $PAGE > 1}}<a href="{{LINK script="playlist_goto" section=$PREV page=$smarty.get.playlist}}">Previous</a>&nbsp;{{/if}}{{if $PAGE < $smarty.section.pages.total}}<a href="{{LINK script="playlist_goto" section=$NEXT page=$smarty.get.playlist}}">Next</a>{{/if}}
</div>

{{section name="list" loop=$PLAYLIST max=$VPP start=$START}}
<div style="width:380px;border: #000000 1px dotted;margin:auto;display:block;margin-bottom:10px">
	<div style="float:left;width:100px;">
		<a href="{{LINK section=$PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}"><img src="{{LINK script='video_thumb' section=$PLAYLIST[list].uri}}" style="height:75px" alt="Video" title="{{$PLAYLIST[list].title}}" /></a>
	</div>
	<div style="float:right;width:275px">
		<h3 style="margin:0"><a href="{{LINK section=$PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}" title="{{$PLAYLIST[list].title}}">{{$PLAYLIST[list].title|truncate:33:''}}</a></h3>
		<div><strong>{{$LANG.duration|ucfirst|default:"Duration"}}:</strong> {{$PLAYLIST[list].duration|date_format:"%M:%S"}}</div>
		<div><strong>{{$LANG.framerate|ucfirst|default:"Bitrate"}}:</strong> {{$PLAYLIST[list].rate}} / {{$PLAYLIST[list].rate_hq}} kbps</div>
		<div><strong>{{$LANG.filesize|ucfirst|default:"Filesize"}}:</strong> {{$PLAYLIST[list].filesize}} / {{$PLAYLIST[list].filesize_hq}} MiB</div>
	</div>
	<div style="clear:left"></div>
</div>

{{sectionelse}}
<div>{{$LANG.no_videos|default:"No videos"}}</div>
{{/section}}
{{*<div style="clear:left">&nbsp;</div>*}}
</div>

