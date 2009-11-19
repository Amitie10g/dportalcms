		</div>
		<div style="margin:10px 0">
		<a href="#comment">{{$LANG.publish_comment|ucfirst}} </a> | 
		<a href="{{LINK script='blog'}}">{{$LANG.return|ucfirst}}</a>
		</div>
		</div>
		
		<a name="comments"></a>
		<div style="border-bottom:1px black dotted">
		{{BLOG_MESSAGE stype='comment' dtype=$MESSAGE.0 message=$MESSAGE.1}}
		<div class="blog_commens">
		<h3 style="text-align:center">{{$LANG.comments|ucfirst}}</h3>
