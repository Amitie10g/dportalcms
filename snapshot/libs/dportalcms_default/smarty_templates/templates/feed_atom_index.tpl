<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text"><![CDATA[{{$LANG.blog_entries}}Blog entries :: {{$SITENAME|default:'DPortal CMS'}}]]></title>
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK script="blog"}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK script="blog_feed"}}"/>
     <id>tag:{{$smarty.server.SERVER_NAME}},{{$ENTRIES.0.id|date_format:"%Y-%m-%d"}}:blog/</id>
     <updated>{{$ENTRIES.0.updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>

{{section name="entries" loop=$ENTRIES}}
     <entry>
       <title><![CDATA[{{$ENTRIES[entries].title}}]]></title>
       <link rel="alternate" type="text/html" href="{{LINK section=$ENTRIES[entries].name script='blog_entry'}}"/>
       <id>tag:{{$smarty.server.SERVER_NAME}},{{$ENTRIES[entries].id|date_format:"%Y-%m-%d"}}:{{$ENTRIES[entries].name|escape:"url"}}</id>
       <updated>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
       <published>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</published>
       <author>
	<name>{{$PHPBB_USERNAME|default:"Administrator"}}</name>
       </author>
        <content type="html" xml:lang="en"><![CDATA[
         {{fetch2 file=$ENTRIES[entries].file truncate=500}}
       ]]></content>
     </entry>
{{/section}}
</feed>
