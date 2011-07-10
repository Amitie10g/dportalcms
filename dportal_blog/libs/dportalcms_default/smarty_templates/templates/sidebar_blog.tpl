<div style="padding:0 2px">
{{if !empty($ENTRIES_SIDEBAR)}}<h3 style="text-align:center;font-weight:bold;margin:0;padding:0">{{$LANG.entries|ucfirst}}</h3>{{/if}}

{{foreach from=$ENTRIES_SIDEBAR item="MONTH" key="YEAR"}}
	<ul{{* id="ye_{{$YEAR}}"*}} class="maketree">
		<li style="padding:0 0 5px 5px"><a href="{{LINK script="blog" page="$YEAR/" argument="?year=$YEAR"}}" style="margin-left: -5px">{{$YEAR}}</a>
{{foreach from=$MONTH item="ENTRY" key="MONTH"}}
			<ul id="mo_{{$YEAR}}_{{$MONTH}}" class="maketree">
				<li style="padding:0 0 5px 8px"><a href="{{LINK script="blog" page="$YEAR/$MONTH" argument="?year=$YEAR&month=$MONTH"}}" style="margin-left:-5px">{{$MONTH|month_number_to_locale_string}}</a>
					<ul class="maketree">
{{foreach from=$ENTRY item="ENTRY" key="ITEM"}}
						<li style="padding:0 0 5px 8px"><a href="{{LINK script="blog_entry" section=$ENTRY.name}}" title="{{$ENTRY.title}}">{{$ENTRY.title|truncate:11:null:true}}</a></li>
					
{{/foreach}}
					</ul>
				</li>
			</ul>
{{/foreach}}
		</li>
	</ul>
{{/foreach}}
</div>
