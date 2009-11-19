<div class="content">
	<div class="blog_entry">
{{$MESSAGE}}
		<h2 class="blog_entry_title">{{$TITLE}}</h2>
		<h3 class="blog_entry_date">Publicado el {{$ID|date_format:"%d/%m/%Y"}} a las {{$ID|date_format:"%H:%M"}}{{if $IS_ADMIN}} | 
		<a href="{{$PATH}}/blog.php?EDIT&amp;entry={{$NAME}}">Editar</a> | 
		<a href="{{$PATH}}/blog.php?DELETE&amp;entry={{$NAME}}">Borrar</a>{{/if}}</h3>
		<div>
			{{fetch file=$FILE|default:"entries/no_data"}}
		</div>
		<div style="margin:10px 0"><a href="{{$PATH}}/blog/">Volver</a></div>
		<div class="blog_commens">
{{* Aca van los Comentarios, en un Bloque SECTION *}}
		</div>
		<div class="blog_comment">
{{* Aca va el Formulario para publicar Comentarios *}}
		</div>
	</div>
</div>