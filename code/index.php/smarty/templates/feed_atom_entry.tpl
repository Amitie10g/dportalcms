<?xml version="1.0" encoding="utf-8"?>
{{fetch file=$ENTRY.file assign='CONTENT'}}
<feed xmlns="http://www.w3.org/2005/Atom">

	<title>{{$ENTRY.title}} :: {{$SITENAME|default:"DBlog"}}</title>
	<subtitle>{{$LANG.entry_summary_and_comments}}</subtitle>
	<link href="http://{{$smarty.server.SERVER_NAME}}{{$smarty.const.DPORTAL_PATH}}/blog/{{$NAME}}_atom.xml" rel="self" />
	
	<author>
		<name>{{$phpbb_username|default:$LANG.administrator}}</name>
	</author>
	
	<entry>
	<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
	<updated>{{$TIMESTAMP|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<author>
		<name>{{$phpbb_username|default:$LANG.administrator}}</name>
	</author>
	<summary>{{$CONTENT|truncate:300:' (...)'}}</summary>
    </entry>
</feed>