{{*
	Here is a little problem with Caching, but is not critical.

	When this chunk is cached into 'chapter.tpl', also will be cached the Hostname.
	For testing purposes, I've used two address: 'localhost' (127.0.0.1) and '192.168.xxx.1',
	one for use the Website as Administrator (loged-in) and the other as Anonymous user
	(the two IP addresses are, obviously, the same machine).
	
	There, when I load the page form '192.168.xxx.1', the pages is cached as them, and
	when I test with 'localhost', the page is cached with the address with 192.168.xxx.1
	as Hostname.
	
	Any problems? Well, actually nothing, because in Production the Website will be
	accessed only to one Hostname.
	
	Better, is testing with different browsers, Iceweasel and Epiphany. I'll use Lynx
	for other testing purposes, as Accesibility. 

*}}<div>
{{section name="chapters" loop=$CHAPTERS}}
{{if count($CHAPTERS[chapters]) > 1}}
{{if $smarty.section.chapters.iteration == $CHAPTER.name}}
{{if $smarty.section.chapters.iteration > 1}}
<div style="float:left"><a href="{{LINK script="chapter" section=$CHAPTER_PREV page=$smarty.get.book argument=$smarty.get.author}}">&#8810;&nbsp;{{$LANG.previous_chapter|ucfirst}}</a></div>
{{/if}}
{{if $smarty.section.chapters.iteration < $smarty.section.chapters.total}}
<div style="float:right"><a href="{{LINK script="chapter" section=$CHAPTER_NEXT page=$smarty.get.book argument=$smarty.get.author}}">{{$LANG.next_chapter|ucfirst}}&nbsp;&#8811;</a></div>
{{/if}}
{{/if}}
{{/if}}
{{/section}}
<div style="clear:left"></div>
</div>

