<?xml version='1.0' encoding='UTF-8'?>
<rss xmlns:atom='http://www.w3.org/2005/Atom' xmlns:gphoto='http://schemas.google.com/photos/2007' xmlns:media='http://search.yahoo.com/mrss/' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' version='2.0'>

<channel>
	<title>{{$TITLE}} :: {{$SITENAME}}</title>
	<link>{{LINK section=$smarty.get.gallery script='gallery_gallery'}}</link>

	<item><description>&lt;a href="{{LINK section=$smarty.get.gallery script='gallery_gallery'}}"&gt;&lt;h2&gt;{{$LANG.go_to_gallery|ucfirst}}&lt;/h2&gt;&lt;/a&gt;&lt;hr /&gt;</description></item>

	{{section name='image' loop=$IMAGELIST}}
	<item>
		<title>{{$IMAGELIST[image].desc|truncate:45:'...':true}}</title>
		<description>&lt;img src="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}"&gt;{{if !$smarty.section.image.last}}&lt;hr /&gt;{{/if}}</description>
		<link>{{LINK section=$IMAGELIST[image].uri script="gallery_image_orig" ext=$IMAGELIST[image].ext}}</link>
	</item>
	{{/section}}

</channel>
</rss>
