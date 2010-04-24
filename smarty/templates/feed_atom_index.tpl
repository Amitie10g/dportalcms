<?xml version="1.0" encoding="iso-8859-1"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 
<channel> 
	<title><![CDATA[Blog ({{$LANG.last_5_entries}}last 5 entries) :: {{$SITENAME|default:'DPortal CMS'}}]]></title> 
	<link><![CDATA[{{LINK script="blog_index"}}]]></link> 
	<description><![CDATA[{{$SITEDESC|default:'DPortal CMS'}}]]></description>
	<language>en</language> 
	<atom:link href="{{LINK script='blog_feed'}}" rel="self" type="application/rss+xml" />
	<ttl>15</ttl> 

	<item>
		{{section name="entries" loop=$ENTRIES}}
		<title><![CDATA[{{$ENTRIES[entries].title}}]]></title>
		<link><![CDATA[{{LINK section=$ENTRIES[entries].name script='blog_entry'}}]]></link>
		<description><![CDATA[{{fetch2 file=$ENTRIES[entries].file truncate=200}}]]></description>
		<guid isPermaLink="true"><![CDATA[{{LINK section=$ENTRIES[entries].name script='blog_entry'}}]]></guid>
		<author>
			<name>{{$phpbb_username|default:$LANG.administrator}}</name>
		</author>
		<pubDate><![CDATA[{{$ENTRIES[entries].id|date_format:"%Y-%m-%dT%H:%M:%SZ"|default:"2009-08-20T00:00:00Z"}}]]></pubDate>
		{{/section}}
	</item>

</channel>

</rss>