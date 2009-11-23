<a name="content" id="content"></a>
<div class="content"{{if $HQ}} style="width:97.5% !important"{{/if}}>
<h5 class="invisible">Content</h5>
<h1>{{$TITLE|ucfirst}}</h1>
<div class="player" style="text-align:center;">
<div id="player" style="margin:0 0 10px 0"></div>
<div>
<span class="video_links"><a href="{{if $HQ}}{{LINK section=$URI script='player' page=$PLAYLIST}}{{else}}{{LINK section=$URI_HQ script='player_hq' page=$PLAYLIST}}{{/if}}" title="{{if $HQ}}Normal view{{else}}View in HQ{{/if}}">{{if $HQ}}Normal view{{else}}View in HQ{{/if}}</a></span> | 
<span class="video_links"><a href="{{LINK section=$PLAYLIST script='playlist'}}">Return to Playlist</a></span>
</div>
</div>
</div>
