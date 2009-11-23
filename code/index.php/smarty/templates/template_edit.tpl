<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.manual_template_edit}} :: {{$SITENAME}}</title>
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
</head>

<body>
<h2><strong>{{$LANG.editing|ucfirst}}</strong> '{{$NAME}}'</h2>
<form method="post" action="{{LINK script='panel' section='template:save' argument='?TEMPLATE_SAVE'}}">
<input type="submit" value="{{$LANG.save|ucfirst}}" /> 
| <a href="{{LINK script="panel"}}">{{$LANG.return_to_panel|ucfirst}}</a><br />
<span style="font-size:10px"><strong>{{$LANG.warning|ucfirst}}:</strong> {{$LANG.incorrect_edition_warn|ucfirst}}</span>
<textarea name="content" cols="20" rows="50" style="width:100%;height:450px;font-size:14px">{{fetch file=$FILE}}</textarea>
<input type="hidden" name="file" value="{{$NAME}}" />
</form>
</body>
</html>
