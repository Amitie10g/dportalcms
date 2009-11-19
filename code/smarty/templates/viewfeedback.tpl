<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.viewing_feedback}}</title>
</head>
<body>

<h1 style="text-align:center">{{$LANG.viewing_feedback}}</h1>

<div style="text-align:center"><a href="{{$smarty.const.DPORTAL_PATH}}/home.html">Return</a></div>

<h3 style="text-align:center">{{$LANG.error_reports}}</h3>

<div style="width:50%;float:center;margin:auto">
{{section name='list' loop=$BUGS}}
<div style="background:{{cycle name="title" values="#999999,#CCCCCC"}};padding:5px">
<div style="padding:2px">
<strong>Sended at</strong> :{{$BUGS[list].timestamp|date_format:"%m/%d/%Y %H:%M:%S"}} - 
<strong>From IP:</strong> {{$BUGS[list].ipadd1}}
{{if isset($BUGS[list].ipadd2)}} ({{$BUGS[list].ipadd2}}){{/if}}</div>
<div style="background:{{cycle name="content" values="#BBBBBB,#EEEEEE"}};padding:3px">
{{$BUGS[list].comment}}
</div>
</div>
{{sectionelse}}<div style="text-align:center"><em>{{$LANG.no_messages}}</em></div>
{{/section}}
</div>

<h3 style="text-align:center">{{$LANG.messages}}comments</h3>

<div style="width:50%;float:center;margin:auto">
{{section name='list' loop=$COMMENTS}}
<div style="background:{{cycle name="title" values="#999999,#CCCCCC"}};padding:5px">
<div style="padding:2px">
<strong>Sended at:</strong> {{$COMMENTS[list].timestamp|date_format:"%m/%d/%Y %H:%M:%S"}} - 
<strong>From IP:</strong> {{$COMMENTS[list].ipadd1}}
{{if isset($COMMENTS[list].ipadd2)}} ({{$COMMENTS[list].ipadd2}}){{/if}}
</div>
<div style="background:{{cycle name="content" values="#BBBBBB,#EEEEEE"}};padding:3px">
{{$COMMENTS[list].comment}}
</div>
</div>
{{sectionelse}}<div style="text-align:center"><em>{{$LANG.no_messages}}</em></div>
{{/section}}
</div>

</body>
</html>