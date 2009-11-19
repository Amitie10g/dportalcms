<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/highslide_html.css" />
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/style.css" />
{{* Hack Style for view the menu properly, if Javascript is disabled.
Unfortunadely, this code don't pass the validator as
XHTML 1.0 Strict, but is not really REALLY important. *}}

<noscript>
<style type="text/css">
.dock-item2 img {
	width: 40px !important;
	margin:0 !important;
}
a.dock-item2 {
	display: inline !important; 
	position: relative !important;
}
</style>
</noscript>

{{if $IS_GALLERY}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}}" href="{{LINK section=$smarty.get.gallery script='gallery_feed'}}" />{{/if}}
{{if $BLOG_ENTRY != null}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}} (Atom)" href="{{LINK section=$smarty.get.entry script='blog_entry_feed'}}" />{{/if}}
{{if ($ENTRIES != null) || ($BLOG_ENTRY != null)}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$LANG.last|ucfirst}} 5 {{$LANG.entries}} (Atom)" href="{{LINK script='blog_feed'}}" />{{/if}}

{{if ($LOGED_IN || $PHPBB_DIR == null) && $IS_VIDEO}}{{include file="script_player.tpl"}}{{/if}}

{{if $IS_GALLERY}}{{include file="gallery_h.tpl"}}{{/if}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/jquery.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/interface.js"></script>

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

{{* Place your own code here *}}

</head>

<body{{CALLAJAX url=$AJAX_URL block=$AJAX_BLOCK}}{{POPUP type=$WARNING_MESSAGE.type message=$WARNING_MESSAGE.message}}>
<div id="container">
<h5 class="invisible">{{if !LOGED_IN}}<a href="#login">{{$LANG.login|ucfirst}}</a> | {{/if}}<a href="#content" rel="nofollow">{{$LANG.jump_to_content|ucfirst}}</a></h5>
<div class="banner" style="background:url({{$menu_file}}) !important;">
<div style="height:100px !important">&nbsp;</div>
<noscript>
<div style="font-style:italic;font-weight:bold;margin:-18px 0 0 0">{{$LANG.enable_javascript_menus}}</div></noscript>
<div class="menu">{{include file="menu.tpl"}}</div>
<div style="clear:both"></div>
</div>
