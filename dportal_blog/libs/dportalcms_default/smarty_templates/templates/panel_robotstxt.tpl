<div style="padding:0 5px">
<div style="padding-top: 10px">{{$LANG.robotstxt_preface}}</div>
<form method="post" action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='config:update' argument='?SITE_CONF'}}{{else}}{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}{{/if}}">
    <textarea name="robotstxt" style="width:99%;height:100px" rows="10"
  cols="15">{{if file_exists('robots.txt')}}{{fetch file="robots.txt"}}{{/if}}</textarea>
  <div style="text-align:center;padding:5px">
    <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" />
  </div>
  </form>
</div>
