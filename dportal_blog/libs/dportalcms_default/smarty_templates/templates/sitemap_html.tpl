<h1 style="margin-bottom:10px">Sitemap</h1>

<div style="margin-left:50%">

<ul style="margin:0 0 5px 3px;padding:3px">
<li><h2 style="margin:0;padding:0"><a href="{{LINK}}">{{$LANG.home|ucfirst}}</a></h2>
{{foreach from=$ENTRIES_SIDEBAR item="MONTH" key="YEAR"}}
	<ul style="margin:0 0 5px 3px;padding:3px">
		<li><h3 style="margin:0;padding:0"><a href="{{LINK script="blog" page="$YEAR/" argument="?year=$YEAR"}}">{{$LANG.entries_of|ucfirst}} {{$YEAR}}</a></h3>
{{foreach from=$MONTH item="ENTRY" key="MONTH"}}
			<ul style="margin:0 0 5px 3px;padding:3px">
				<li><h4 style="margin:0;padding:0"><a href="{{LINK script="blog" page="$YEAR/$MONTH" argument="?year=$YEAR&month=$MONTH"}}">{{$LANG.entries_of|ucfirst}} {{$MONTH|month_number_to_locale_string}}</a></h4>
					<ul style="margin:0 0 5px 3px;padding:3px">
{{foreach from=$ENTRY item="ENTRY" key="ITEM"}}
						<li><h5 style="margin:0;padding:0"><a href="{{LINK script="blog_entry" section=$ENTRY.name}}" title="{{$ENTRY.title}}">{{$ENTRY.title}} ({{$ENTRY.created|date_format:"%A, %B %e, %Y"}})</a></h5></li>
					
{{/foreach}}
					</ul>
				</li>
			</ul>
{{/foreach}}
		</li>
	</ul>
{{/foreach}}
</li>
</ul>
</div>
