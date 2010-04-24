<?xml version="1.0" encoding="utf-8"?>
<rss xmlns:atom='http://www.w3.org/2005/Atom' xmlns:gphoto='http://schemas.google.com/photos/2007' xmlns:media='http://search.yahoo.com/mrss/' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' version='2.0'>
<channel>

	<title>{{$ENTRY.title}} :: {{$SITENAME|default:"DBlog"}}</title>
	<link href="{{LINK section=$ENTRY.name script="blog_entry_feed"}}" rel="self" />
	
	<author>
		<name>{{$phpbb_username|default:$LANG.administrator}}</name>
	</author>
	
	<item>
		<id>urn:uuid:60a76c80-d399-11d9-b91C-0003939e0af6</id>
		<updated>{{$ENTRY.updated|date_format:"%Y-%m-%dT%H:%M:%SZ"}}</updated>
		<author>
			<name>{{$phpbb_username|default:$LANG.administrator|ucfirst}}</name>
		</author>
		<description>{{$ENTRY.content|truncate:300:' (...)'}} &lt;a href="{{LINK section=$ENTRY.name script="blog_entry"}}"&gt;[{{$LANG.goto|ucfirst}} {{$LANG.entry}}]&lt;/a&gt;</description>
		<link href="{{LINK section=$ENTRY.name script="blog_entry"}}" rel="self" />
	</item>
</channel>
</rss>
