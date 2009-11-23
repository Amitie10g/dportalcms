<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/player/swfobject.js"></script>
<script type="text/javascript">
		var attributes = {};

		var params = {};
	 	// for fullscreen
		params.allowfullscreen = "true";

		var flashvars = {};
		// the video file or the playlist file (extension added for compatibility)
		flashvars.file = "{{LINK script='video' section=$URI page=$PLAYLIST}}";

		// the PHP script
		flashvars.streamscript = "{{LINK script='video_script' page=$PLAYLIST}}";
		flashvars.bufferlength = "3";

		// width and height of the player (h is height of the video + 20 for controlbar)
		// required for IE7
		flashvars.width = "{{if $HQ}}640{{else}}400{{/if}}";
		flashvars.height = "{{if $HQ}}380{{else}}245{{/if}}"; // 290 16x9; 380 4x3
		// width  and height of the video (16x9)
		flashvars.displaywidth = "{{if $HQ}}640{{else}}400{{/if}}";
		flashvars.displayheight = "{{if $HQ}}360{{else}}225{{/if}}"; // 270 16x9; 360 4x3
		flashvars.autostart = "false";
		flashvars.showdigits = "true";

	 	// for fullscreen
		flashvars.showfsbutton = "true";

		// 9 for Flash Player 9 (for ON2 Codec and FullScreen)
		swfobject.embedSWF("{{$smarty.const.DPORTAL_PATH}}/player/player.swf", "player", "{{if $HQ}}640{{else}}400{{/if}}", "{{if $HQ}}380{{else}}245{{/if}}", "9.0.0", "playerProductInstall.swf", flashvars, params, attributes);

</script>
