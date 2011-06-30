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
{{if $LOGED_IN}}{{include file="sidebar_user_data.tpl"}}
{{else}}{{include file="sidebar_login.tpl"}}{{/if}}
{{include file="sidebar_c.tpl"}}
{{include file="sidebar_f.tpl"}}
<div class="content">
<a name="content" title="Content"></a>
<h5 class="invisible">Content</h5>
<h3>404: {{$LANG.not_found|ucfirst}}</h3>
<p>{{$LANG.the_section|ucfirst}} <strong>{{$SECTION}}</strong> {{$LANG.does_not_exist}}.<br />
{{$LANG.review_url|ucfirst}}.</p>
<p><a href="{{LINK section='home'}}">{{$LANG.return_to_index|ucfirst}}</a></p>
</div>
{{include file="footer_page.tpl"}}
{{include file="footer.tpl"}}