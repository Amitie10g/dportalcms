  <p style="margin:0;text-align:center">
    
    <img src="http://img89.imageshack.us/img89/47/gplv388x31uf3.png" style="border:0;"
    alt="GPL3" title="DPortal is Free Software" />
  </p>

  <p style="margin:0;text-align:center">
    <a href="http://validator.w3.org/check?uri=referer" rel="external"><img
        src="{{$smarty.const.DPORTAL_PATH}}/images/valid-xhtml10-blue.png"
        alt="Valid XHTML 1.0 Strict" title="Valid XHTML 1.0 Strict"
        style="border:0;width:88px;height:31px" /></a>
  </p>

  <p style="margin:0;text-align:center">
     <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="external"><img
	style="border:0;width:88px;height:31px"
        src="{{$smarty.const.DPORTAL_PATH}}/images/vcss-blue.gif"
        alt="ValidCSS" title="ValidCSS" />
     </a>
  </p>

  <p style="margin:0;text-align:center">
  {{if $IS_GALLERY && $smarty.get.gallery != null}}<a href="http://validator.w3.org/feed/check?uri={{LINK script="gallery_feed" section=$smarty.get.gallery}}">
  {{elseif $IS_ENTRY && $smarty.get.entry != null}}<a href="http://validator.w3.org/feed/check?uri={{LINK script="blog_entry_feed" section=$smarty.get.entry}}">
  {{elseif $IS_BLOG}}<a href="http://validator.w3.org/feed/check?uri={{LINK script="blog_feed"|escape:"url"}}">{{/if}}
<img src="{{$smarty.const.DPORTAL_PATH}}/images/valid-atom.png" alt="Valid Atom 1.0" title="Valid Atom 1.0" />
  {{if $IS_GALLERY || $IS_ENTRY || $IS_BLOG}}</a>{{/if}}
  </p>
