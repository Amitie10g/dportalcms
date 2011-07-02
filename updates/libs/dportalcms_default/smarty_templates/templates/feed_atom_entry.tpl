<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text"><![CDATA[{{$TITLE}} :: {{$SITENAME}}]]></title>     
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK section=$NAME script="blog_entry"}}" title="{{$TITLE}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK section=$NAME script="blog_entry_feed"}}"/>
     <id>tag:{{$smarty.server.SERVER_NAME}},{{$CREATED|date_format:"%Y-%m-%d"}}:{{$NAME}}/</id>
     <updated>{{$UPDATED|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>

     <entry>
	<title type="text"><![CDATA[{{$TITLE}}]]></title>
	<author>
		<name><![CDATA[{{$PHPBB_USERNAME|default:"Administrator"}}]]></name>
	</author>
	<link rel="alternate" type="text/html" href="{{LINK section=$NAME script='blog_entry'}}"/>
	<updated>{{$UPDATED|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<id>tag:{{$smarty.server.SERVER_NAME}},{{$CREATED|date_format:"%Y-%m-%d"}}:{{$NAME}}/</id>
	<content type="html" xml:lang="en"><![CDATA[
	{{fetch2 file=$FILE truncate=1000}}
	]]></content>
     </entry>
   </feed>