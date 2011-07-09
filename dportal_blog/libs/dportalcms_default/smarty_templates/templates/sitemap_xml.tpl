<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
{{foreach key="key" item="category" from=$SECTIONS}}
   {{foreach key="section_key" item="section" from=$category}}
   <url>
      <loc>{{LINK section=$section.name}}</loc>
      <lastmod>{{$section.name.timestamp|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>{{$section.priority|default:"0.5"}}</priority>
   </url>
{{/foreach}}
{{/foreach}}

{{* Blog *}}
   <url>
      <loc>{{LINK script='blog'}}</loc>
      <lastmod>{{$LAST_ENTRY|date_format:"%Y-%m-%d"}}</lastmod>
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

</urlset>