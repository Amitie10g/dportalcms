<div class="content">
<a name="content"></a>
<h5 class="invisible">{{$LANG.content}}</h5>
{{include file=$TEMPLATE}}
{{DYNAMIC}}
{{if $IS_ADMIN && file_exists($GALLERY)}}
<hr />
<div style="text-align:center">
<h3>{{$LANG.upload_images|ucfirst}}</h3>
<form id="form5" method="post" action="{{LINK script='panel' section='gallery:upload' argument='?UPLOAD_GALLERY'}}" enctype="multipart/form-data">
	<p>
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	<input type="file" name="images[]" style="width:250px" /><br />
	</p>
	<p><input type="hidden" name="gallery" value="{{$smarty.get.gallery}}" /><p>
	<p><input type="submit" value="    {{$LANG.upload|ucfirst}}    " /></p>
</form>
</div>
{{/if}}
{{/DYNAMIC}}

</div>
