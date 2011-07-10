<link rel="shortcut icon" href="{{$smarty.const.DPORTAL_PATH}}/images/favicon.ico" />

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/ajax.js"></script>

<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/highslide/highslide.css" />
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/style.css" />

<script type="text/javascript">
//<![CDATA[
document.write("<style type='text/css'>.dock-container2{ position:absolute !important; margin:auto !important; }a.dock-item2 { position:absolute !important; } .dock-item2 img { width: 100% !important; margin:5px 10px 0px !important; } a.separator { position:absolute !important; padding: 0 !important; margin: 5px 25px 0px 25px !important; width:1px !important; padding:1px !important; }</style>");
//]]>
</script>

{{if $IS_GALLERY && !empty($GALLERY)}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}}" href="{{LINK section=$smarty.get.gallery script='gallery_feed'}}" />{{/if}}
{{if $IS_ENTRY}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}} (Atom)" href="{{LINK section=$smarty.get.entry script='blog_entry_feed'}}" />{{/if}}
{{if ($ENTRIES != null) || ($BLOG_ENTRY != null)}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$LANG.last|ucfirst}} 5 {{$LANG.entries}} (Atom)" href="{{LINK script='blog_feed'}}" />{{/if}}

{{include file="script_player.tpl"}}

{{if $IS_GALLERY}}{{include file="gallery_h.tpl"}}{{/if}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/jquery.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/css-dock-menu/js/interface.js"></script>

{{include file="google_search.tpl"}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

{{if $IS_BLOG}}
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/listCollapse.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/cookie.js"></script>
<script type="text/javascript">
window.onload = function () {
{{foreach name="year" from=$ENTRIES_SIDEBAR item="MONTH" key="YEAR"}}
  compactMenu('ye_{{$YEAR}}',false,'&plusmn; ');
  stateToFromStr('ye_{{$YEAR}}',retrieveCookie('menuState'));
{{foreach name='month' from=$MONTH item="ENTRY" key="MONTH"}}
  compactMenu('mo_{{$YEAR}}_{{$MONTH}}',false,'&plusmn; ');
  stateToFromStr('mo_{{$YEAR}}_{{$MONTH}}',retrieveCookie('menuState'));
{{/foreach}}
{{/foreach}}
}
window.onunload = function () {
  setCookie('menuState',stateToFromStr('someID'));
}
</script>
{{/if}}

{{* Place your own code here *}}

