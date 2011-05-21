<h1 style="margin-bottom:10px">{{$LANG.galleries|ucfirst}}</h1>

{{section name='list' loop=$LIST}}
<div style="width:400px;float:center;margin:auto;border:#000000 1px dotted">
	<div style="float:left;padding:5px">
		<a href="{{LINK section=$LIST[list].dirname script="gallery_gallery"}}"><img style="max-width:150px;max-height:100px" src="{{if $LIST[list].num != null}}{{LINK section=$LIST[list].uri script='gallery_image_prev' ext=$LIST[list].ext}}{{else}}http://{{$smarty.server.SERVER_NAME}}{{$smarty.const.DPORTAL_PATH}}/images/no_images_150-70.png{{/if}}" alt="{{$LIST[list].gallery_title}}" /></a>
	</div>
	<div style="margin-left:160px;">
			<h2 style="margin:2px 0 7px 0"><a href="{{LINK section=$LIST[list].dirname script="gallery_gallery"}}">{{$LIST[list].gallery_title}}</a></h2>
			<div style="margin:2px 0 7px 0">{{if $LIST[list].num != null}}{{$LIST[list].num}} images, {{$LIST[list].dirsize}} KiB.{{else}}{{$LANG.no_images|ucfirst|regex_replace:"/\.([\w\s])*/":'.'}}{{/if}}</div>
			{{if $LIST[list].num != null}}<div><a href="{{LINK section=$LIST[list].dirname script="gallery_feed"}}">[Feed]</a></div>{{/if}}
	</div>
	<div style="clear:left"></div>
</div>
{{sectionelse}}<div style="text-align:center">{{$LANG.no_galleries|ucfirst}}</div>
{{/section}}

