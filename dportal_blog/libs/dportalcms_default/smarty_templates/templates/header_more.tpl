<link rel="shortcut icon" href="{{$smarty.const.DPORTAL_PATH}}/images/favicon.ico" />
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/ajax.js"></script>

{{if $IS_ENTRY}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$TITLE}} (Atom)" href="{{LINK section=$smarty.get.entry script='blog_entry_feed'}}" />{{/if}}
{{if ($ENTRIES != null) || ($BLOG_ENTRY != null)}}<link rel="alternate" type="application/atom+xml" title="{{$SITENAME}} - {{$LANG.last|ucfirst}} 5 {{$LANG.entries}} (Atom)" href="{{LINK script='blog_feed'}}" />{{/if}}

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/listCollapse.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/cookie.js"></script>
<script type="text/javascript">//<![CDATA[
window.onload = function getTreeCollapse() {
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

//]]></script>

{{include file="google_search.tpl"}}

{{* Place your own code here *}}
