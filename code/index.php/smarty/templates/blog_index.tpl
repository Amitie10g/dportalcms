<div class="content">
<a name="content" title="Content"></a>

<h5 class="invisible">{{$LANG.content}}</h5>
<h1>Blog{{if $PAGE == 1 && $ENTRIES != null}}. {{$LANG.last|ucfirst}} {{$EPP|default:'3'}} {{$LANG.entries}}{{/if}}</h1>
{{BLOG_MESSAGE stype='index' dtype=$MESSAGE.0 message=$MESSAGE.1}}
{{include file="blog_index_goto.tpl"}}
{{section name=entries loop=$ENTRIES max=$EPP start=$START}}
{{if $smarty.section.entries.last}}<div class="blog_entry_last">{{else}}<div class="blog_entry">{{/if}}

  <h2 class="blog_entry_title" style="margin:0"><a href="{{LINK script='blog_entry' section=$ENTRIES[entries].name}}">{{$ENTRIES[entries].title}}</a></h2>
  <h3 class="blog_entry_date" style="font-size:10px;margin:0 10px 10px 0">{{$LANG.published_at|ucfirst}} {{$ENTRIES[entries].id|date_format:"%d/%m/%Y %T"}}</h3>
  <div class="blog_entry_content">
    {{fetch file=$ENTRIES[entries].file}}
  </div>
 <div style="margin:10px 0"><a href="{{LINK script='blog_entry' section=$ENTRIES[entries].name}}#comment">{{$LANG.post_comment|ucfirst}}</a></div>
</div>
{{sectionelse}}
<div style="text-align:center;font-style:italic;font-size:15px;margin:10px">{{$LANG.no_entries_published}}</div>
{{/section}}
{{include file="blog_index_goto.tpl"}}
</div>
