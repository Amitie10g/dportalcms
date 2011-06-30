<form method="post" action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">
<div style="text-align:right; margin: 0 auto;width:500px">
  <div style="float:left"><strong>{{$LANG.memcached_server|ucfirst}}Memcached server:</strong>
      <input type="text"
  name="memcached_server" value="{{$MEMCACHED_SERVER}}" style="width:150px" />
    <br />
    <strong>localhost</strong> by default.</div>
  <div style="float:right"><strong>{{$LANG.memcached port|ucfirst}}Memcached port:</strong>
      <input type="text"
  name="memcached_port" value="{{$MEMCACHED_PORT}}" style="width:50px" />
    <br />
    <strong>11211</strong> by default.</div>
	<div style="clear:both">&nbsp;</div>
</div>
<div style="text-align:center">
  <input name="submit" type="submit" value="    {{$LANG.save|ucfirst}}    " />
  <div>&nbsp;</div>
</div>
</form>
