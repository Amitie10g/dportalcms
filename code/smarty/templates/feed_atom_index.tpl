<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text">{{$LANG.blog_entries}}Blog entries :: {{$SITENAME|default:'DPortal CMS'}}</title>
     <link rel="alternate" type="text/html" hreflang="en" href="{{LINK script="blog"}}"/>
     <link rel="self" type="application/atom+xml" href="{{LINK script="blog_feed"}}"/>

{{section name="entries" loop=$ENTRIES}}
     <entry>
       <title>{{$ENTRIES[entries].title}}</title>
       <link rel="alternate" type="text/html" href="{{LINK section=$ENTRIES[entries].name script='blog_entry'}}"/>
       <id>tag:example.org,2003:3.2397</id>
       <updated>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
       <published>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</published>

        <content type="xhtml" xml:lang="en"
        xml:base="http://diveintomark.org/">
         {{fetch2 file=$ENTRIES[entries].file truncate=200}}
       </content>
     </entry>
{{/section}}
</feed>
