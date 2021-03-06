<h5 class="invisible">{{$LANG.content}}</h5>
<h1>{{$LANG.blog|ucfirst}}{{if !empty($TAG)}} - Viewing entries with tag "{{$TAG}}"{{elseif $PAGE == 1 && $ENTRIES != null}}. {{$LANG.last|ucfirst}} {{$EPP}} {{$LANG.entries}}{{/if}}</h1>
{{DYNAMIC}}
{{if $smarty.session.blog_entry_deleted}}
<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.entry_deleted|ucfirst}}</div>
{{elseif $smarty.session.blog_entry_error}}
<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.blog_entry_error|ucfirst}}</div>
{{elseif $smarty.session.blog_entry_deleted}}
<div style="border:1px #000000 dotted; padding:5px; width:350px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.blog_entry_doesnt_exist|ucfirst}}</div>
{{/if}}
{{/DYNAMIC}}

{{include file="blog_index_goto.tpl"}}

{{section name=entries loop=$ENTRIES max=$EPP start=$START}}
{{if $smarty.section.entries.last && count($ENTRIES) < $EPP}}<div class="blog_entry_last">{{else}}<div class="blog_entry">{{/if}}

  <h2 class="blog_entry_title" style="margin:0"><a href="{{LINK script='blog_entry' section=$ENTRIES[entries].name}}">{{$ENTRIES[entries].title}}</a></h2>
  <h3 class="blog_entry_date" style="font-size:10px;margin:0 10px 10px 0">{{$LANG.published_at|ucfirst}} {{$ENTRIES[entries].created|date_format:"%d/%m/%Y %T"}}</h3>

  <div class="blog_entry_content">
    {{if !empty($TAG)}}{{fetch2 file=$ENTRIES[entries].file truncate=500}}{{else}}{{fetch2 file=$ENTRIES[entries].file}}{{/if}}
  </div>
    
 <div style="margin:0 0 10px 0"><a href="{{LINK script='blog_entry' section=$ENTRIES[entries].name marker="comment"}}">{{$LANG.post_comment|ucfirst}}</a>{{if !empty($ENTRIES[entries].tags)}} | <span style="font-weight:bold">{{$LANG.tags|ucfirst}}:</span> 
 {{foreach name="tags" item="tag" from=$ENTRIES[entries].tags}}
 <a href="{{LINK script="blog" section="tag:$tag" argument="?tag=$tag"}}">{{$tag}}</a>{{if !$smarty.foreach.tags.last}}, {{/if}}
 {{/foreach}}
 {{/if}}</div>
</div>
{{if !$IS_ADMIN && ($smarty.section.entries.index == $SHOW_AD_INDEX_PAIR || $smarty.section.entries.index == $SHOW_AD_INDEX_IMPAIR) && empty($TAG)}}
{{* Inser your Ads or Banners here. Them will appear based on the configuration *}}
{{/if}}
{{sectionelse}}
{{DYNAMIC}}<div style="text-align:center;font-style:italic;font-size:15px;margin:10px">{{$LANG.no_entries_published|ucfirst}}.{{if $IS_ADMIN}} {{$LANG.create_entry_now|ucfirst}}.{{/if}}</div>{{/DYNAMIC}}
{{/section}}
{{include file="blog_index_goto.tpl"}}

