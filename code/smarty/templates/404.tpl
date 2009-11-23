{{include file="header.tpl"}}
{{include file="header_more.tpl"}}
{{include file="sidebar_h.tpl"}}
{{if $LOGED_IN}}{{include file="sidebar_user_data.tpl"}}
{{else}}{{include file="sidebar_login.tpl"}}{{/if}}
{{include file="sidebar_c.tpl"}}
{{include file="sidebar_f.tpl"}}
<div class="content">
<a name="content" title="Content"></a>
<h5 class="invisible">Content</h5>
<h3>404: {{$LANG.not_found|ucfirst}}</h3>
<p>{{$LANG.the_section}} <strong>{{$SECTION}}</strong> {{$LANG.does_not_exist}}. 
{{$LANG.review_url}}.</p>
<p><a href="{{LINK section='home'}}">{{$LANG.return_to_index}}</a></p>
</div>
{{include file="footer.tpl"}}
