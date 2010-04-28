<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text">{{$TITLE|regex_replace:"/[&]*/":''|regex_replace:"/((acute|grave|tilde)*;)/":''}} :: {{$SITENAME}}</title>
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK section=$smarty.get.gallery script='gallery_gallery'}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK section=$smarty.get.gallery script='gallery_feed'}}"/>

{{section name='image' loop=$IMAGELIST}}
     <entry>
       <title>{{$IMAGELIST[image].desc|truncate:45:'...':true}}</title>
       <link rel="alternate" type="text/html" href="{{LINK section=$IMAGELIST[image].uri  script="gallery_image_orig" ext=$IMAGELIST[image].ext}}"/>
	{{*<link rel="enclosure" type="{{$IMAGELIST[image].mimetype}}"
        href="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}"/>*}}
        <content type="html" xml:lang="en"
        xml:base="http://diveintomark.org/">
	&lt;h2&gt;{{$ENTRIES[entries].title}}&lt;/h2&gt;
	&lt;img src="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}"&gt;
       </content>
     </entry>
{{/section}}
</feed>