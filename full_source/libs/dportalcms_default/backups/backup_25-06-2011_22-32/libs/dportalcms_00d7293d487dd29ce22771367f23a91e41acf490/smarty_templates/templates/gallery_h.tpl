<script type="text/javascript">
window.onLoad=callajax('{{$smarty.const.DPORTAL_PATH}}/gallery.php?AJAX&amp;page=1', 'contents');
</script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/highslide/highslide-with-gallery.js"></script>

<script type="text/javascript">
	hs.graphicsDir = '{{$smarty.const.DPORTAL_PATH}}/highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.wrapperClassName = 'controls-in-heading';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.25;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: false,
		overlayOptions: {
			opacity: 1,
			position: 'top right',
			hideOnMouseOut: false
		}
	});

</script>

<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/highslide/highslide.css" />
