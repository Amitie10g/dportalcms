<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
{{section name="sections" loop=$SECTIONS}}
   <url>
      <loc>{{LINK section=$SECTIONS[sections].name}}</loc>
      <lastmod>{{$SECTIONS[sections].timestamp|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>{{$SECTIONS[sections].priority|default:"0.5"}}</priority>
   </url>
{{/section}}

{{* Galleries *}}

   <url>
      <loc>{{LINK script='gallery_index'}}</loc>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>

{{section name="galleries" loop=$GALLERIES}}
   <url>
      <loc>{{LINK section=$GALLERIES[galleries].dirname script='gallery_gallery'}}</loc>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>
{{/section}}

{{* Blog *}}
   <url>
      <loc>{{LINK script='blog'}}</loc>
      <lastmod>{{$LASTENTRY|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.8</priority>
   </url>

{{section name="entries" loop=$ENTRIES}}
   <url>
      <loc>{{LINK script="blog_entry" section=$ENTRIES[entries].name}}</loc>
      <lastmod>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>
{{/section}}

{{section name="playlists" loop=$PLAYLISTS}}
   <url>
      <loc>{{LINK script="blog_entry" section=$ENTRIES[entries].name}}</loc>
      <lastmod>{{$ENTRIES[entries].updated|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>
{{/section}}

</urlset>
