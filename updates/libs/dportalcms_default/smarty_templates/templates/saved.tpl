<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.information|ucfirst}} :: {{$SITENAME}} (editor)</title>
<link rel="stylesheet" type="text/css" href="{{LINK script="stylesheet"}}" />
</head>
<body>
<div style="max-width:400px;margin:100px auto;float:center;text-align:center;border:#4474BC 2px solid;background:#DDDDDD">
<h5 class="titre">{{$LANG.information|ucfirst}}</h5>

<div style="float:left;text-align:center;width:15%;margin:10px 0 0 10px">
{{if $UPDATED}}
<img src="{{$smarty.const.DPORTAL_PATH}}/images/information.png" width="50" height="50" alt="{{$LANG.information}}" />
{{elseif $WARNING}}
<img src="{{$smarty.const.DPORTAL_PATH}}/images/warning.png" width="50" height="50" alt="{{$LANG.warning}}" />
{{else}}
<img src="{{$smarty.const.DPORTAL_PATH}}/images/error.png" width="50" height="50" alt="Error" />
{{/if}}
</div>
<div style="float:right;width:75%;text-align:left !important;padding: 0 10px 0 0">
{{if $UPDATED}}
<div style="margin:10px 10px 20px 0">{{$LANG.section|ucfirst}} &quot;{{$SECTION}}&quot; {{$LANG.updated_success}} </div>
<div style="text-align:right;padding:10px">
<a href="{{LINK script='edit' section=$SECTION  page='section:' argument='?section='}}" style="padding:2px 15px;border:4px #00EEFF inset;background:#00EEFF">{{$LANG.edit|ucfirst}}</a>
<a href="{{if $smarty.session.PANEL}}{{LINK script='panel' section='sections' argument="?tab=sections"}}{{else}}{{LINK section=$SECTION}}{{/if}}" style="padding:2px 15px;border:4px #00EEFF inset;background:#00EEFF">{{$LANG.return|ucfirst}}</a>
</div>
</div>
{{elseif $WARNING}}
<p>{{$LANG.sure_delete_section}}</p>
<div style="float:left;padding:10px;margin:10px">

<span><a href="#" style="margin:10px 5px 0 30px;padding:2px 15px;border:4px #00EEFF inset;background:#00EEFF">{{$LANG.yes}}</a></span>

<div style="float:right">
<a href="={{LINK section="home"}}" style="margin:10px 5px;padding:2px 15px;border:4px #00EEFF inset;background:#00EEFF">{{$LANG.no}}</a>
</div>
{{else}}
<p>{{$LANG.error_update_entry|ucfirst}}</p>
<div style="text-align:right;padding:0">
<div style="margin:10px 10px 20px 0">
<a href="{{LINK section='home'}}" style="margin:10px 5px;padding:2px 15px;border:4px #00EEFF inset;background:#00EEFF">{{$LANG.return_to_index|ucfirst}}</a></div>
</div>
</div>
{{/if}}
<div class="cleaner"></div>
</div>
</body>
</html>
