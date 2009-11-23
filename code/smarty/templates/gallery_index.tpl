<h1 style="margin-bottom:10px">{{$LANG.galleries|ucfirst}}</h1>

{{section name='list' loop=$LIST}}
<div style="width:400px;float:center;margin:auto;border:#000000 1px dotted">
	<div style="float:left;padding:5px">
		<a href="{{LINK section=$LIST[list].dirname script="gallery_gallery"}}"><img style="max-width:150px" src="{{LINK section=$LIST[list].uri script='gallery_image' ext=$LIST[list].ext}}" alt="{{$LIST[list].gallery_title}}" /></a></div>
		<div>
			<h2 style="margin:2px 0 7px 0"><a href="{{LINK section=$LIST[list].dirname script="gallery_gallery"}}">{{$LIST[list].gallery_title}}</a></h2>
			<div style="margin:2px 0 7px 0">{{$LIST[list].num}} images, {{$LIST[list].dirsize}} KiB.</div>
			<div><a href="{{LINK section=$LIST[list].dirname script="gallery_feed"}}">[Feed]</a></div>		
		</div>
	<div style="clear:left"></div>
</div>
{{sectionelse}}<div>{{$LANG.no_images|ucfirst}}</div>
{{/section}}

