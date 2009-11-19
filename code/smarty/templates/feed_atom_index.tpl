<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title>Blog :: {{$SITENAME|default:'DPortal CMS'}}</title>
	<subtitle>{{$LANG.last_5_entries}}</subtitle>
	<link href="{{LINK script='blog_feed'}}" rel="self" />
	<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
	<updated>{{$LAST_ENTRY|date_format:"%Y-%m-%dT%H:%M:%SZ"|default:"2009-08-20T00:00:00Z"}}</updated>
	<author>
		<name>{{$phpbb_username|default:$LANG.administrator}}</name>
	</author>
 
{{section name="entries" loop=$ENTRIES}}
{{fetch file=$ENTRIES[entries].file assign="CONTENT"}}
	<entry>
		<title>{{$ENTRIES[entries].title}}</title>
		<link href="http://{{$smarty.server.SERVER_NAME}}{{LINK section=$ENTRIES[entries].name script='blog_entry'}}" />
		<id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id>
		<updated>{{$ENTRIES[entries].id|date_format:"%Y-%m-%dT%H:%M:%SZ"|default:"2009-08-20T00:00:00Z"}}</updated>
		<summary>{{$CONTENT|truncate:300:' (...)'|escape}}</summary>
		<author>
			<name>{{$phpbb_username|default:$LANG.administrator}}</name>
		</author>
	</entry>
{{/section}}
</feed>
