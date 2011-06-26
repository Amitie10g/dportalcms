<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback :: {{$SITENAME}}</title>
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>
</head>
<body style="padding:0">

<div style="width:100%;margin:0">

{{if ($COUNTDOWN > 0 && $COUNTDOWN < 900)}}
<div style="margin:50px auto;text-align:center">
<p><strong>Thanks for send your message. We read them shortly.</strong><br />
Please wait {{$SCOUNTDOWN|string_format:"%d"}} minutes if you wish to publish another message.</p>
</div>
{{else}}
<h2>Thanks for visite{{$LANG.thanks_for_visite}}</h2>

<div>{{$LANG.feedback_desc|ucfirst}}</div>

<div>{{$LANG.if_you_wish_to_participate|ucfirst}}<a href="http://groups.google.com/group/dportalcms" rel="external">{{$LANG.visite_google_group}}</a></div>

<div style="padding:5px;">

<form method="post" action="{{$smarty.server.PHP_SELF}}?SUBMIT">

<div><textarea style="width:99%" name="content" cols="20" rows="5"></textarea></div>

<div style="text-align:center;width:99%"><input style="width:50%"
type="submit" value="{{$LANG.send|ucfirst}}" /></div>

</form>

</div>

<div style="font-size:10px;padding:0 3px;">
{{$LANG.privacy_desc|ucfirst}}

<a name="kp"></a><h3>{{$LANG.known_issues|ucfirst}}</h3>

{{$LANG.known_issues_desc}}

</div>
{{/if}}
</div>
</body>
</html>
