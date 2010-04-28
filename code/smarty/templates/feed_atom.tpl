{{*<?xml version="1.0" encoding="utf-8"?>
 
<feed xmlns="http://www.w3.org/2005/Atom">

{{if $IS_INDEX}}
	<title>{{$SITENAME|default:"DBlog"}}</title>
	<subtitle>Ultimas 3 entradas del Blog</subtitle>
	<link href="http://{{$smarty.server.SERVER_NAME}}{{$PATH}}/blog/atom.xml" rel="self" />
	<link href="{{$smarty.server.SERVER_NAME}}/" />
	<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
	<updated>{{$LAST_ENTRY|date_format:"%Y-%m-%dT%H:%M:%SZ"|default:"2009-08-20T00:00:00Z"}}</updated>
	<author>
		<name>{{$phpbb_username|default:"davod"}}</name>
	</author>
 
        {{section name="entries" loop=$ENTRIES}}
	<entry>
		<title>{{$ENTRIES[entries].title}}</title>
		<link href="http://{{$smarty.server.SERVER_NAME}}/blog/entry={{$ENTRIES[entries].id}}_atom.xml" />
		<id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id>
		<updated>{{$ENTRIES[entries].id|date_format:"%Y-%m-%dT%H:%M:%SZ"|default:"2009-08-20T00:00:00Z"}}</updated>
		<summary>{{$ENTRIES[entries].content|escape}}</summary>
		<author>
			<name>{{$phpbb_username|default:"davod"}}</name>
		</author>
	</entry>
        {{/section}}
{{elseif $IS_ENTRY}}

	<title>{{$SITENAME|default:"DBlog"}}</title>
	<subtitle>{{$ENTRY.title}}Hola</subtitle>
	<link href="http://{{$smarty.server.SERVER_NAME}}{{$PATH}}/blog/{{$NAME}}_atom.xml" rel="self" />
	
	<entry>
	<link href="{{$smarty.server.SERVER_NAME}}/" />
	<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
	<updated>{{$TIMESTAMP|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<author>
		<name>{{$phpbb_username|default:"Administrator"}}</name>
	</author>
	<summary>{{$ENTRIES[entries].content|escape}}</summary>
    </entry>
{{/if}}
</feed>*}}
<?xml version="1.0" encoding="utf-8"?>
   <feed xmlns="http://www.w3.org/2005/Atom">
     <title type="text">dive into mark</title>
     <subtitle type="html">
       A &lt;em&gt;lot&lt;/em&gt; of effort
       went into making this effortless
     </subtitle>
     <updated>2005-07-31T12:29:29Z</updated>
     <id>tag:example.org,2003:3</id>
     <link rel="alternate" type="text/html"
      hreflang="en" href="http://example.org/"/>
     <link rel="self" type="application/atom+xml"
      href="http://example.org/feed.atom"/>
     <rights>Copyright (c) 2003, Mark Pilgrim</rights>
     <generator uri="http://www.example.com/" version="1.0">
       Example Toolkit
     </generator>
     <entry>
       <title>Atom draft-07 snapshot</title>
       <link rel="alternate" type="text/html"
        href="http://example.org/2005/04/02/atom"/>
       <link rel="enclosure" type="audio/mpeg" length="1337"
        href="http://example.org/audio/ph34r_my_podcast.mp3"/>
       <id>tag:example.org,2003:3.2397</id>
       <updated>2005-07-31T12:29:29Z</updated>
       <published>2003-12-13T08:29:29-04:00</published>
       <author>
         <name>Mark Pilgrim</name>
         <uri>http://example.org/</uri>
         <email>f8dy@example.com</email>
       </author>
       <contributor>
         <name>Sam Ruby</name>
       </contributor>
       <contributor>
         <name>Joe Gregorio</name>
       </contributor>
       <content type="xhtml" xml:lang="en"
        xml:base="http://diveintomark.org/">
         <div xmlns="http://www.w3.org/1999/xhtml">
           <p><i>[Update: The Atom draft is finished.]</i></p>
         </div>
       </content>
     </entry>
   </feed>



