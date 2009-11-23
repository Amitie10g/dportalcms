<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
{{section name="sections" loop=$SECTIONS}}
   <url>
      <loc>http://{{$smarty.server.SERVER_NAME}}{{if $SECTIONS[sections].name != 'home'}}/index.php?seccion={{$SECTIONS[sections].name}}{{/if}}</loc>
      <lastmod>{{$SECTIONS[sections].timestamp|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>{{$SECTIONS[sections].priority|default:"0.5"}}</priority>
   </url>
{{/section}}

{{section name="galleries" loop=$GALLERIES}}
   <url>
      <loc>http://{{$smarty.server.SERVER_NAME}}{{LINK section=$GALLERIES[galleries] script='gallery_gallery'}}</loc>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>
{{/section}}

   <url>
      <loc>http://{{$smarty.server.SERVER_NAME}}{{LINK script='blog'}}</loc>
      <lastmod>{{$LASTENTRY|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.8</priority>
   </url>

{{section name="entries" loop=$ENTRIES}}
   <url>
      <loc>http://{{$smarty.server.SERVER_NAME}}/blog.php?seccion={{$ENTRIES[entries]}}</loc>
      <lastmod>{{$ENTRIES[entries]|date_format:"%Y-%m-%d"}}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.5</priority>
   </url>
{{/section}}
</urlset>
