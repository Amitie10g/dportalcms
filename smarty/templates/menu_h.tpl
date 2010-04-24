<noscript><div style="font-style:italic;font-weight:bold;margin:-18px 0 0 0">{{$LANG.enable_javascript_menus}}</div></noscript>
<div class="menu">

{{* This is an Example Menu with "CSS Dock Menu"; you can customize them. Please see README_MENU for details *}}
<div class="dock2" id="dock2">
	<div class="dock-container2">
		<a class="dock-item2" href="{{LINK section="home"}}"><span>{{$LANG.home|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/home.png" alt="{{$LANG.home|ucfirst}}" /></a>
		<a class="dock-item2" href="{{$smarty.const.DPORTAL_PATH}}/feedback.php" onclick="window.open('feedback.php','Feedback','width=500,height=350');return false;"><span>{{$LANG.contact|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/message.png" alt="{{$LANG.contact|ucfirst}}" /></a>
		<a class="dock-item2" href="http://code.google.com/p/dportalcms/downloads"><span>{{$LANG.download|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/download.png" alt="{{$LANG.download|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK section="links"}}"><span>{{$LANG.links|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/link.png" alt="{{$LANG.links|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK script="blog"}}"><span>{{$LANG.blog|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/blog.png" alt="{{$LANG.blog|ucfirst}}" /></a>
		<a class="dock-item2" href="/forum"><span>{{$LANG.forum|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/forum.png" alt="{{$LANG.forum|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK script="gallery_index"}}"><span>{{$LANG.gallery|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/images.png" alt="{{$LANG.gallery|ucfirst}}" /></a>
		<a class="dock-item2" href="{{LINK script="showcase"}}"><span>{{$LANG.videos|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/multimedia.png" alt="{{$LANG.videos|ucfirst}}" /></a>

