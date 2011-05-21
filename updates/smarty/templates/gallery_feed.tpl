<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
     <title type="text"><![CDATA[{{$TITLE}} :: {{$SITENAME}}]]></title>
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK section=$smarty.get.gallery script='gallery_gallery'}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK section=$smarty.get.gallery script='gallery_feed'}}"/>
     <id>tag:{{$smarty.server.SERVER_NAME}},{{$CREATED|date_format:"%Y-%m-%d"}}:gallery/</id>
     <updated>{{$UPDATED|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>

{{section name='image' loop=$IMAGELIST}}
     <entry>
       <title><![CDATA[{{$IMAGELIST[image].desc|truncate:45:'...':true}}]]></title>
       <link rel="alternate" type="text/html" href="{{LINK section=$IMAGELIST[image].uri  script="gallery_image_orig" ext=$IMAGELIST[image].ext}}"/>
	{{*<link rel="enclosure" type="{{$IMAGELIST[image].mimetype}}"
        href="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}"/>*}}
        <id>tag:{{$smarty.server.SERVER_NAME}},{{$IMAGELIST[image].updated|date_format:"%Y-%m-%d"}}:gallery/{{$IMAGELIST[image].desc|escape:"url"}}d</id>
	<updated>{{$IMAGELIST[image].updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<author>
	  <name>Administrator</name>
	</author>
        <content type="html" xml:lang="en">
	&lt;h2&gt;{{$ENTRIES[entries].title}}&lt;/h2&gt;
	&lt;img src="{{LINK section=$IMAGELIST[image].uri script="gallery_image" ext=$IMAGELIST[image].ext}}"&gt;
       </content>
     </entry>
{{/section}}
</feed>