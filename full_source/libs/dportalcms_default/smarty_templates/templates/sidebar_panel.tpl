<ul class="list">
{{if $IS_ADMIN}}
<li class="list"><a href="/panel.php" rel="external">Administraci&oacute;n</a></li>
{{/if}}
{{if $PHPBB_URL_PATH != null}}<li class="list"><a href="{{$PHPBB_URL_PATH}}ucp.php">Ir al panel phpBB -&gt;</a></li>{{/if}}
<li class="list"><a href="{{if $PHPBB_URL_PATH != null}}{{$PHPBB_URL_PATH}}ucp.php?mode=logout&redirect={{$smarty.server.REQUEST_URI}}{{else}}{{$smarty.server.PHP_SELF}}?LOGOUT{{/if}}">Cerrar sesi&oacute;n</a><li>
</ul>
</div>

<hr style="margin:0" />
