<h1>Sitemap</h1>

<div style="width:600px;margin:auto">
<h2><a href="{{LINK section="home"}}">{{$LANG.sections|ucfirst}}</a></h2>

<ul>
{{foreach key="key" item="category" from=$SECTIONS}}
   <li><h3><a href="{{LINK script="category" section=$key}}">{{$key|get_category_title}}</a></h3></li>
   <ul>
   {{foreach key="section_key" item="section" from=$category}}
       <li><a href="{{LINK section=$section.name}}">{{$section.title}}</a></li>
   {{/foreach}}
   </ul>
{{/foreach}}
</ul>

<h2><a href="{{LINK script='gallery_index'}}">{{$LANG.galleries|ucfirst}}</a></h2>

<ul>
{{section name="galleries" loop=$GALLERIES}}
   <li><a href="{{LINK section=$GALLERIES[galleries].dirname script='gallery_gallery'}}">{{$GALLERIES[galleries].title}}</a></li>
{{/section}}
</ul>

<h2><a href="{{LINK script='blog'}}">Blog</a></h2>

<ul>
{{section name="entries" loop=$ENTRIES}}
   <li><a href="{{LINK script="blog_entry" section=$ENTRIES[entries].name}}">{{$ENTRIES[entries].title}}</a> ({{$ENTRIES[entries].published|date_format:"%m/%d/%Y"}})</li>
{{/section}}
</ul>

<h2><a href="{{LINK script="showcase"}}">Media player</a></h2>

<ul>
{{foreach key="key" item="playlists" from=$PLAYLISTS}}
      <li><h3><a href="{{LINK script="playlist" section="$key"}}">{{$playlists.title}}</a></h3></li>
	  
	  <ul>
{{foreach item="videos" from=$playlists.videos}}
	  	<li><a href="{{LINK script="player" section=$videos.uri page=$key}}">{{$videos.title}}</a></li>
{{/foreach}}
	  </ul>
{{/foreach}}
</ul>

</div>
