<a name="content" id="content"></a>
<div class="content"{{if $HQ}} style="width:97.5% !important"{{/if}}>
<h5 class="invisible">Content</h5>
<h1>{{$TITLE|ucfirst}}</h1>
<div class="player" style="text-align:center;">
<div id="player" style="margin:0 0 10px 0">

<noscript>
<div style="width:400px;height:245px;background:#000000;padding: 10px;margin:auto">
	<div style="float:left"><img src="{{$smarty.const.DPORTAL_PATH}}/images/warning.png" /></div>
	<div style="text-align:left;margin:8px;font-weight:bold"><span style="color:#FFFFFF;font-size:14px">Please enable Javascript to get the Player, or Login to Download the original video.</span></div>
</div>
</noscript>

</div>
<div>
<span class="video_links"><a href="{{if $HQ}}{{LINK section=$URI script='player' page=$PLAYLIST}}{{else}}{{LINK section=$URI_HQ script='player_hq' page=$PLAYLIST}}{{/if}}" title="{{if $HQ}}Normal view{{else}}View in HQ{{/if}}">{{if $HQ}}Normal view{{else}}View in HQ{{/if}}</a></span>&nbsp;|&nbsp;
{{DYNAMIC}}{{if $LOGED_IN}}<span class="video_links"><a href="{{LINK script='video_download' section=$URI page=$PLAYLIST}}">Download original</a></span>&nbsp;|&nbsp;{{/if}}{{/DYNAMIC}}
<span class="video_links"><a href="{{LINK section=$PLAYLIST script='playlist'}}">Return to Playlist</a></span>
</div>
</div>
</div>
