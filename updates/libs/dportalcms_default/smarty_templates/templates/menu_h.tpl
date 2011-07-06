<noscript><div style="font-style:italic;font-weight:bold;margin:-18px 0 0 0">{{$LANG.enable_javascript_menus}}</div></noscript>
<div class="menu">

{{* This is an Example Menu with "CSS Dock Menu"; you can customize them. Please see README_MENU for details *}}
<div class="dock2" id="dock2"> 
	<div class="dock-container2">
		<a class="dock-item2" href="{{LINK section="home"}}"><span>{{$LANG.home|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/home.png" alt="{{$LANG.home|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK section="links"}}"><span>{{$LANG.links|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/link.png" alt="{{$LANG.links|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK script="blog"}}"><span>{{$LANG.blog|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/blog.png" alt="{{$LANG.blog|ucfirst}}" /></a>
		{{if $PHPBB_URL_PATH != null}}<a class="dock-item2" href="{{$PHPBB_URL_PATH}}"><span>{{$LANG.forum|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/forum.png" alt="{{$LANG.forum|ucfirst}}" /></a>{{/if}}
		<a class="dock-item2" href="{{LINK script="gallery_index"}}"><span>{{$LANG.gallery|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/images.png" alt="{{$LANG.gallery|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK script="showcase"}}"><span>{{$LANG.videos|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/multimedia.png" alt="{{$LANG.videos|ucfirst}}" /></a>

