{{* This is an Example Menu; you can cuntomise them. Please see README_MENU for details *}}
<div class="dock2" id="dock2">
  <div class="dock-container2">
		<a class="dock-item2" href="{{LINK section="home"}}"><span>Home</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/Nuvola_filesystems_folder_home.png" alt="Home" /></a>
		<a class="dock-item2" href="{{$smarty.const.DPORTAL_PATH}}/feedback.php" onclick="window.open('feedback.php','Feedback','width=500,height=500');return false;"><span>Contact</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/Nuvola_apps_email.png" alt="Contact" /></a>
		<a class="dock-item2" href="http://code.google.com/p/dportalcms/downloads"><span>Download!</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/download.png" alt="Descarga" /></a>
		<a class="dock-item2" href="{{LINK section="links"}}"><span>Links</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/link.png" alt="Links" /></a>
		<a class="dock-item2" href="{{LINK script="blog"}}"><span>Blog</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/Nuvola_apps_klipper.png" alt="Blog" /></a>
		<a class="dock-item2" href="/forum"><span>Forum</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/gaim.png" alt="Forum" /></a>
		<a class="dock-item2" href="{{LINK script="gallery_index"}}"><span>Gallery</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/Nuvola_apps_kcoloredit.png" alt="Gallery" /></a>
		<a class="dock-item2" href="{{LINK script="showcase"}}"><span>Videos</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/multimedia.png" alt="Videos" /></a>
		{{* Separator *}}
		<a class="dock-item2" href="#" onclick="return false" style="margin:1px !important;width:20px !important;padding:1px !important;cursor:pointer"><img src="css-dock-menu/images/separator.png" style="height:45px !important; width:6px !important" alt="" /></a>
		{{* Specific items *}}
		<a class="dock-item2" href="{{LINK section="lipsum"}}"><span>Lorem Ipsum</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/document.png" alt="Lorem ipsum" /></a>
		<a class="dock-item2" href="{{LINK section="history"}}"><span>History</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/history.png" alt="Historia" /></a>
		{{* Dynamic items, currently no yet implemented *}}
		{{*include file="$MENU_CATEGORY.tpl"*}}
  </div>
</div>
<!--dock menu JS options -->
<script type="text/javascript">
	$(document).ready(function(){	$('#dock2').Fisheye({maxWidth: 60,items: 'a',itemsText: 'span',container: '.dock-container2',itemWidth: 40,proximity: 80,alignment : 'left',halign : 'center'})});
</script>
