<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback :: {{$SITENAME}}</title>
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css">
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>
</head>
<body style="padding:0">

<div style="width:100%;margin:0">

{{if ($COUNTDOWN > 0 && $COUNTDOWN < 900)}}
<div style="margin:50px auto;text-align:center">
<p><strong>Thanks for send your message. We read them shortly.</strong><br />
Please wait {{$SCOUNTDOWN|string_format:"%d"}} minutes if you wish to publish another.</p>
</div>
{{else}}
<h2>Thanks for visite</h2>

<div>Aqui puedes escribir tus comentarios o sugerencias sobre el Portal o el 
Programa, o para reportar algun problema con la Aplicaci&oacute;n o el sitio Web. 
Si ves problemas, por favor revisa 
<strong>Problemas conocidos</strong> m&aacute;s abajo.</div>

<div>Si deseas participar el el <strong>Proyecto</strong>, por favor <a href="http://groups.google.com/group/dportalcms" rel="external">visita el Grupo</a></div>

<div style="padding:5px;">

<form method="post" action="{{$smarty.server.PHP_SELF}}?SUBMIT">

  <div>
      <label>
      <input name="type" type="radio" value="true" checked="checked" />
      Problema</label>
    <label>
      <input type="radio" name="type" value="false" />
      Sugerencia</label>
    <br />
  </div>

<div><textarea style="width:99%" name="content" cols="20" rows="5"></textarea></div>

<div style="text-align:center;width:99%"><input style="width:50%"
type="submit" value=" Enviar " /></div>

</form>

</div>

<div style="font-size:10px;padding:0 3px;">

<p><strong>Privacidad:</strong> Este <strong>Feedback</strong> es completamente 
an&oacute;nimo y s&oacute;lo quedar&aacute; registrada la <strong>direcci&oacute;n IP</strong> 
(para verificar la procedencia en caso de mensajes mal intencionados). 
Los datos NO ser&aacute;n publicados ni informados bajo ninguna cirunstancia; s&oacute;lo ser&aacute;n
usados para conocer las opiniones de la gente y para Depuraci&oacute;n.</p>

<a name="kp"></a><h3>Problemas conocidos</h3>

<p><strong>Los Men&uacute;s no funcionan correctamente en IE.</strong> 
Si usas <strong>Internet Explorer</strong>, los men&uacute;s no desaparecen cuando sacas el puntero de ellos.<br />
<strong>Soluci&oacute;n:</strong> No usen el IE (6 y 7) &lt;_&gt; Si el IE no pasa ni el 
<a href="http://acid2.acidtests.org/" rel="external">Acid Test 2</a> ni el 
<a href="http://acid3.acidtests.org/" rel="external">Acid Test 3</a>, 
&iquest;como quieren que se vea correctamente el men&uacute;? o.o</p>

<p><strong>Al tratar de bajar las im&aacute;genes de la Galer&iacute;a me aparece el mensaje "Access deined"</strong>
Es una caracter&iacute;stica del portal que impide linkear im&aacute;genes, 
y s&oacute;lo se pueden ver desde la misma.<br />
Si tienes problemas para visualizar una imagen o video, prueba con recargar la p&aacute;gina. 
Si el problema persiste, es que estamos arreglando algunas cosas.</p>

</div>
{{/if}}
</div>
</body>
</html>
