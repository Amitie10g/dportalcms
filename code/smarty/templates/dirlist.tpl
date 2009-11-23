<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unir archivos fragmentados</title>

<style type="text/css">
.cleaner {clear:both;padding:0px;margin:0px;height:0px;font-size:0px;}
</style>

</head>
<body>
<h1>Uni&oacute;n de archivos fragmentados</h1>

<p>la siguiente lista contiene los archivos en el Directorio donde colocar&aacute;
los archivos divididos en partes.{{*<br />
Los nombres en rojo son con partes que no se han unido.
Los verdes son archivos que se han unido correctamente.<br />
Los archvos en color azul son archivos completos sin partes.*}}</p>

{{if isset($MESSAGE)}}
<strong><em>{{$MESSAGE}}</em></strong>

{{/if}}
<p>Aseg&uacute;rate de haber leido la <a href="#checklist">
Lista de comprobaci&oacute;n</a></p>

<div>

<div style="width:150px;float:left"><strong>Archivo</strong></div>
<div><strong>Acciones</strong></div>
<div>------------------------------------------------------------</div>
{{section name="item" loop=$LIST}}
<div style="width:140px;padding:5px 0;margin:5px 0 0 0;float:left;font-weight:bold">{{$LIST[item]}}</div>
{{if file_exists("archivos/$LIST[item]")}}
<div style="width:100px;padding:5px 0;float:left">
<form method="get" action="{{$smarty.server.PHP_SELF}}">
<input type="hidden" name="SPLIT" value="true">
<select name="splitsize" onchange="submit();"
title="Divide el archivo en el tama&ntilde;o seleccionado">
   <option selected="selected" disabled="disabled">Dividir</option>
   {{html_options values=$OVALUE output=$ONAME selected=$OSELECTED}}
</select>
<input type="hidden" name="filename" value="{{$LIST[item]}}">
</form>

</div>
<div style="float:left;padding:5px 0;margin:5px 0"><a href="archivos/{{$LIST[item]}}"
title="Descargar el archivo">Descargar</a></div>
{{else}}
<div style="width:80px;padding:5px 0;margin:0 10px;float:left">
<a href="{{$smarty.server.PHP_SELF}}?MERGE&amp;file={{$LIST[item]}}">Unir partes</a></div>
<div>&nbsp;</div><br />
{{/if}}
</div>
<div class="cleaner"></div>
{{sectionelse}}
<strong><em>No hay archivos</em></strong>
{{/section}}
<div>------------------------------------------------------------</div>

<a name="checklist"></a><h4>Lista de comprobaci&oacute;n</h4>

<ol>
<li>Dividir el Archivo en partes con el programa de tu preferencia<br />
(Hacha, HJSpliter, etc) pero tiene que ser dividido EN BRUTO.</li>
<li>Subir todas las partes al directorio correspondiente para hacer la uni&oacute;n.<br />
Aseg&uacute;rate que el directorio tenga permisos de escritura</li>
<li>Seleccionar al Archivo a unir y que la operaci&oacute;n finalice correctamente<br />
(un mensaje indicar&aacute; el &eacute;xito). NO cierres la ventana hasta que aparezca el mensaje.
<li>Y listo xD El archivo se puede mover a otro directorio</li>
</ol>
</body>
</html>
