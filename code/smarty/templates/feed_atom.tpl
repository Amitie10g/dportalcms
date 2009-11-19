<?xml version="1.0" encoding="utf-8"?>
 
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
	<subtitle>Entrdad {{$TITLE}} y Comentarios</subtitle>
	<link href="http://{{$smarty.server.SERVER_NAME}}{{$PATH}}/blog/{{$NAME}}_atom.xml" rel="self" />
	
	<entry>
	<link href="{{$smarty.server.SERVER_NAME}}/" />
	<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
	<updated>{{$TIMESTAMP|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
	<author>
		<name>{{$phpbb_username|default:"davod"}}</name>
	</author>
	<summary>{{$ENTRIES[entries].content|escape}}</summary>
	<comments>Hola</comments>
    </entry>
{{/if}}
</feed>

