<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text">{{$SITENAME}}</title>     
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK section=$ENTRY.name script="blog_entry"}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK section=$ENTRY.name script="blog_entry_feed"}}"/>
     <id>tag:{{$smarty.server.SERVER_NAME}},{{$ENTRY.id|date_format:"%Y-%m-%d"}}:{{$ENTRY.name}}/</id>
     <updated>{{$ENTRY.updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>

     <entry>
	<title type="text">{{$ENTRY.title}}</title>
	<author>
		<name>{{$PHPBB_USERNAME|default:"Administrator"}}</name>
	</author>
	<link rel="alternate" type="text/html" href="{{LINK section=$ENTRY.name script='blog_entry'}}"/>
	<updated>{{$ENTRY.updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<id>tag:{{$smarty.server.SERVER_NAME}},{{$ENTRY.id|date_format:"%Y-%m-%d"}}:{{$ENTRY.name}}/</id>
	<content type="html" xml:lang="en">
	{{$ENTRY.content|truncate:500:' (...)'|strip_tags|escape:"htmlall"}}
	</content>
     </entry>
   </feed>