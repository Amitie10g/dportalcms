<div style="padding: 10px">{{$LANG.upload_videos_note}}</div>
<div style="padding:10px;width:500px;margin:auto">
{{if !empty($PLAYLISTS)}}
  <form id="form6" method="post"
action="{{LINK script='panel' section='videos/upload' argument='?PLAYLIST'}}"
enctype="multipart/form-data">
  <div style="padding: 10px">
  <select class="list" name="playlist" style="width:90%" onchange="submit()">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_playlist_to_upload}}</option>
    {{section name="playlists" loop=$PLAYLISTS}}
    <option value="{{$PLAYLISTS[playlists].dirname}}" {{if $PLAYLISTS[playlists].dirname == $PLAYLIST}}selected="selected"{{/if}}>{{$PLAYLISTS[playlists].dirname}} -
    {{$PLAYLISTS[playlists].title}}</option>{{/section}}
  </select>
   </div>
   </form>

{{if !empty($PLAYLIST)}} 




<div style="width:100%;padding:0 0 10px 0">
<form method="post" action="{{LINK script="panel" section="video:delete" argument="?DELETE_VIDEO"}}">
<input type="hidden" name="playlist" value="{{$smarty.get.playlist}}" />

{{section name="list" loop=$GET_PLAYLIST}}
<div style="width:390px;height:75px;border: #000000 1px dotted;margin:auto;display:block;margin-bottom:10px">
	<div style="float:left;width:100px;">
		<a href="{{LINK section=$GET_PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}"><img src="{{LINK script='video_thumb' section=$GET_PLAYLIST[list].uri}}" style="height:75px" alt="Video" title="{{$GET_PLAYLIST[list].title}}" /></a>
	</div>
	<div style="float:right;width:280px">
		<div style="float:right"><input type="checkbox" name="video[]" value="{{$GET_PLAYLIST[list].uri}}" /></div>
		<h3 style="margin:0;font-size:14px;margin-bottom:10px"><a href="{{LINK section=$GET_PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}" title="{{$GET_PLAYLIST[list].title}}">{{$GET_PLAYLIST[list].title|truncate:35:'':true|ucfirst:null:true}}</a></h3>
		{{if $GET_PLAYLIST[list].duration != null}}<div style="float:left"><strong>{{$LANG.duration|ucfirst}}:</strong>&nbsp;{{$GET_PLAYLIST[list].duration|date_format:"%M:%S"}}&nbsp;|&nbsp;</div>{{/if}}
		{{if $GET_PLAYLIST[list].rate != null}}<div><strong>{{$LANG.bitrate|ucfirst}}:</strong>&nbsp;&nbsp;{{$GET_PLAYLIST[list].rate}}{{if $GET_PLAYLIST[list].rate_hq != null}} / {{$GET_PLAYLIST[list].rate_hq}}{{/if}} kbps</div>{{/if}}
		<div><strong>{{$LANG.filesize|ucfirst}}:</strong>&nbsp;&nbsp;{{$GET_PLAYLIST[list].filesize}}{{if $GET_PLAYLIST[list].filesize_hq != null}} / {{$GET_PLAYLIST[list].filesize_hq}}{{/if}} MiB</div>
	</div>
	<div style="clear:left"></div>

</div>

{{sectionelse}}
<div style="text-align:center;padding: 10px">{{$LANG.no_videos_uploaded|ucfirst}}</div>
{{/section}}
{{if !empty($GET_PLAYLIST)}}<div style="text-align:center"><input type="submit" value="    {{$LANG.delete|ucfirst}}    " /></div>{{/if}}
</form>
</div>

<div style="text-align:center"><h2>Upload videos</h2></div>

  <form id="form6" method="post"
action="{{LINK script='panel' section='video:upload' argument='?UPLOAD_VIDEO'}}"
enctype="multipart/form-data">


  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right;margin-bottom:10px">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right;margin-bottom:10px">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right;margin-bottom:10px">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right;margin-bottom:10px">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div><input type="hidden" name="playlist" value="{{$PLAYLIST}}"  /></div>
  <div style="text-align:center;padding: 10px"><input type="submit" value="  {{$LANG.upload|ucfirst}}  " /></div>
</form>
{{/if}}
{{else}}
<div style="text-align:center">No Playlists. Create a playlist now!</div>
{{/if}}
</div>