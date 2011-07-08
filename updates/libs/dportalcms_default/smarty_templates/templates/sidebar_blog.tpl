<div style="padding:0 2px">
<h3 style="text-align:center;font-weight:bold;margin:0;padding:0">{{$LANG.entries|ucfirst}}</h3>
{{foreach from=$ENTRIES_SIDEBAR item="MONTH" key="YEAR"}}
<ul style="padding:0 0 0 18px">
<li style="padding:0 0 3px 0;margin:0"><a href="{{LINK script="blog" page="$YEAR/" argument="?year=$YEAR"}}" style="margin-left: -8px">{{$YEAR}}</a></li>
{{foreach from=$MONTH item="ENTRY" key="MONTH"}}
<ul style="padding:0 0 0 8px">
<li style="padding:0 0 3px 0;margin:0"><a href="{{LINK script="blog" page="$YEAR/$MONTH" argument="?year=$YEAR&month=$MONTH"}}" style="margin-left:-8px">{{$MONTH|month_number_to_locale_string}}</a></li>


{{foreach from=$ENTRY item="ENTRY" key="ITEM"}}
<ul style="padding:0 0 0 8px">
<li style="padding:0 0 5px 0;margin:0"><a href="{{LINK script="blog_entry" section=$ENTRY.name}}" style="margin-left:-8px" title="{{$ENTRY.title}}">{{$ENTRY.title|truncate:12:null:true}}</a></li>
</ul>
{{/foreach}}


</ul>
{{/foreach}}
</ul>
{{/foreach}}
</div>
<hr />
