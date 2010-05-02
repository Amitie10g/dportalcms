<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/highslide_html.css" />
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/style.css" />

<script type="text/javascript">
//<![CDATA[ 
document.write("<style type='text/css'>.dock-container2{ position:absolute !important; margin:auto !important; }a.dock-item2 { position:absolute !important; } .dock-item2 img { width: 100% !important; margin:5px 10px 0px !important; } a.separator { position:absolute !important; padding: 0 !important; margin: 5px 25px 0px 25px !important; width:1px !important; padding:1px !important; }</style>");
//]]>
</script>

{{if $IS_GALLERY}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}}" href="{{LINK section=$smarty.get.gallery script='gallery_feed'}}" />{{/if}}
{{if $IS_ENTRY}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}} (Atom)" href="{{LINK section=$smarty.get.entry script='blog_entry_feed'}}" />{{/if}}
{{if ($ENTRIES != null) || ($BLOG_ENTRY != null)}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$LANG.last|ucfirst}} 5 {{$LANG.entries}} (Atom)" href="{{LINK script='blog_feed'}}" />{{/if}}

{{if ($LOGED_IN || $PHPBB_DIR == null) && $IS_VIDEO}}{{include file="script_player.tpl"}}{{/if}}

{{if $IS_GALLERY}}{{include file="gallery_h.tpl"}}{{/if}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/jquery.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/interface.js"></script>

{{include file="google_search.tpl"}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

{{* Place your own code here *}}
</head>
<body{{CALLAJAX url=$AJAX_URL block=$AJAX_BLOCK}}{{POPUP type=$WARNING_MESSAGE.type message=$WARNING_MESSAGE.message}}>
<div id="container">
<h5 class="invisible">{{if !LOGED_IN}}<a href="#login">{{$LANG.login|ucfirst}}</a> | {{/if}}<a href="#content" rel="nofollow">{{$LANG.jump_to_content|ucfirst}}</a></h5>
<div class="banner" style="background:url({{$BANNER_URL}}) !important;">
<div style="height:100px !important">&nbsp;</div>
