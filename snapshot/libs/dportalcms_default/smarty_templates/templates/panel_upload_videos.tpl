<div style="padding:10px;width:500px;margin:auto">
{{if !empty($PLAYLISTS)}}
  <form id="form6" method="post"
action="{{LINK script='panel' section='video:upload' argument='?UPLOAD_VIDEO'}}"
enctype="multipart/form-data">
  <div style="padding: 10px">
  <select class="list" name="playlist" style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_playlist_to_upload}}</option>
    {{section name="playlists" loop=$PLAYLISTS}}
    <option value="{{$PLAYLISTS[playlists].dirname}}">{{$PLAYLISTS[playlists].dirname}} -
    {{$PLAYLISTS[playlists].title}}</option>{{/section}}
  </select>
   </div>

  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="padding:10px;text-align:center;font-weight:bold">More?</div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>
  <div style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /></div>
  <div style="text-align:right">{{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></div>

  <div><input type="submit" value="{{$LANG.upload|ucfirst}}" /></div>
</form>
{{else}}
<div style="text-align:center">No Playlists. Create a playlist now!</div>
{{/if}}
</div>