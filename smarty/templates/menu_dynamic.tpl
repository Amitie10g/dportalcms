
	{{* Separator *}}
	<a class="separator" onclick="return false"><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/separator.gif" class="separator" alt="" /></a>

{{* Dynamic items *}}
{{section name=menu loop=$ITEMS max=5}}
	{{if $ITEMS[menu].name != "home"}}<a class="dock-item2" href="{{LINK section=$ITEMS[menu].name}}"><span>{{$ITEMS[menu].title}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/document.png" alt="{{$ITEMS[menu].title}}" /></a>{{/if}}
{{/section}}


	{{* All items for a Category *}}
	<a class="dock-item2" href="{{LINK section=$CATEGORY_NAME script="category"}}"><span>{{$LANG.all_sections_in|ucfirst}} {{$CATEGORY_TITLE}}</span><img src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/images/categories.png" alt="{{$LANG.ALL_SECTIONS_IN}}All sections in {{$CATEGORY_TITLE}}" /></a>


