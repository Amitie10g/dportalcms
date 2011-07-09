<h1>Sitemap</h1>

<div style="width:600px;margin:auto">

<h2><a href="{{LINK script='blog'}}">Blog</a></h2>

{{foreach from=$ENTRIES_SIDEBAR item="MONTH" key="YEAR"}}
	<ul>
		<li><a href="{{LINK script="blog" page="$YEAR/" argument="?year=$YEAR"}}">{{$YEAR}}</a>
{{foreach from=$MONTH item="ENTRY" key="MONTH"}}
			<ul>
				<li><a href="{{LINK script="blog" page="$YEAR/$MONTH" argument="?year=$YEAR&month=$MONTH"}}">{{$MONTH|month_number_to_locale_string}}</a>
					<ul>
{{foreach from=$ENTRY item="ENTRY" key="ITEM"}}
						<li><a href="{{LINK script="blog_entry" section=$ENTRY.name}}" title="{{$ENTRY.title}}">{{$ENTRY.title}}</a></li>
					
{{/foreach}}
					</ul>
				</li>
			</ul>
{{/foreach}}
		</li>
	</ul>
{{/foreach}}
</div>

</div>
