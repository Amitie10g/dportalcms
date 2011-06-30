{{include file="header.tpl"}}
{{include file="header_title.tpl"}}
{{include file="header_more.tpl"}}
{{include file="header_close.tpl"}}
{{include file="body_h.tpl"}}
{{include file="container.tpl"}}
{{include file="menu_h.tpl"}}
{{include file="menu_f.tpl"}}
{{include file="header_f.tpl"}}
{{include file="sidebar_h.tpl"}}
{{include file="sidebar_user_data.tpl"}}
{{include file="sidebar_book.tpl"}}
{{include file="sidebar_c.tpl"}}
{{include file="sidebar_f.tpl"}}
<div class="content">
<a name="content" title="Content"></a>
<h5 class="invisible">Content</h5>
<h3>404: {{$LANG.not_found|ucfirst}}</h3>
<p><strong>{{$LANG.chapter_no_exists|ucfirst}}.</strong><br />
{{$LANG.review_url|ucfirst}}.</p>
{{if $IS_ADMIN}}<p>{{$LANG.admin_create_book|ucfirst}}</p>{{/if}}
</div>
{{include file="footer_page.tpl"}}
{{include file="footer.tpl"}}