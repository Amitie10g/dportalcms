	{{* Separator *}}
	<a class="separator" onclick="return false"><img src="{{$smarty.const.DPORTAL_PATH}}/images/separator.gif" class="separator" alt="" /></a>

	{{* All Categories *}}
	<a class="dock-item2" href="{{LINK script="categories"}}"><span>{{$LANG.all_categories|ucfirst}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/images/categories.png" alt="{{$LANG.all_categories|ucfirst}}" /></a>
	</div>
</div>
<!--dock menu JS options -->
<script type="text/javascript">
	$(document).ready(function(){	$('#dock2').Fisheye({maxWidth: 60,items: 'a',itemsText: 'span',container: '.dock-container2',itemWidth: 40,proximity: 80,alignment : 'left',halign : 'center'})});
</script>
</div>

