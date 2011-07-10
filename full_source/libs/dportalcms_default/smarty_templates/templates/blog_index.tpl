<h5 class="invisible">{{$LANG.content}}</h5>
<h1>{{$LANG.blog|ucfirst}}{{if $PAGE == 1 && $ENTRIES != null && empty($YEAR_CHECKED)}} - {{$LANG.last|ucfirst}} {{$EPP}} {{$LANG.entries}}{{/if}}{{if !empty($YEAR_CHECKED)}} - {{$LANG.entries_of|ucfirst}} {{if !empty($MONTH_CHECKED)}}{{$MONTH_CHECKED|month_number_to_locale_string}} {{/if}}{{$YEAR_CHECKED}}{{/if}}</h1>
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
    {{fetch2 file=$ENTRIES[entries].file}}
  </div>
    
 <div style="margin:0 0 10px 0"><a href="{{LINK script='blog_entry' section=$ENTRIES[entries].name marker="comment"}}">{{$LANG.post_comment|ucfirst}}</a></div>
</div>
{{if !$IS_ADMIN && ($smarty.section.entries.index == $SHOW_AD_INDEX_PAIR || $smarty.section.entries.index == $SHOW_AD_INDEX_IMPAIR)}}
<div style="margin:10px 0;padding:{{if $smarty.section.entries.last && $PAGE == 1}}15px{{else}}0{{/if}} 0 {{if $smarty.section.entries.last && $PAGE == 1}}0{{else}}15px{{/if}} 0;{{if !$smarty.section.entries.last || $PAGE > 1}}border-bottom:1px #000000 dotted;{{/if}}{{if $smarty.section.entries.last && $PAGE == 1}}border-top:1px #000000 dotted;{{/if}}text-align:center">
<script type="text/javascript"><!--
google_ad_client = "pub-6520136901650033";
/* 728x90, Blog index */
google_ad_slot = "3724442520";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
{{/if}}
{{sectionelse}}
{{DYNAMIC}}<div style="text-align:center;font-style:italic;font-size:15px;margin:10px">{{$LANG.no_entries_published|ucfirst}}.{{if $IS_ADMIN}} {{$LANG.create_entry_now|ucfirst}}.{{/if}}</div>{{/DYNAMIC}}
{{/section}}
{{include file="blog_index_goto.tpl"}}

