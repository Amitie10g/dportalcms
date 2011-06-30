<div class="content">
<a name="content"></a>
<h5 class="invisible">{{$LANG.content}}</h5>
<h1>{{$LANG.gallery|ucfirst}}: {{$TITLE}}</h1>

{{if $smarty.session.IMAGES_DELETED}}<div class="message_ok">{{$LANG.images_deleted}}</div>
{{elseif $smarty.session.IMAGES_NON_DELETED}}<div class="message_error">{{$LANG.images_non_deleted}}</div>
{{elseif $smarty.session.IMAGES_UPLOADED}}<div class="message_ok">{{$LANG.images_uploaded}}</div>
{{elseif $smarty.session.IMAGES_NON_UPLOADES}}<div class="message_error">{{$LANG.images_non_uploaded}}</div>
{{/if}}

<div style="margin:0;text-align:center;">
{{if $IMAGELIST}}<form method="post" action="{{LINK script="panel" section="gallery:delete_image" argument="?DELETE_IMAGE"}}">
<div><input type="hidden" name="gallery" value="{{$smarty.get.gallery}}" /></div>{{/if}}
{{section name='image' loop=$IMAGELIST}}
<div class="image_gallery">
      <div style="text-align:right"><label><a href="{{LINK section=$IMAGELIST[image].uri  script="gallery_image_orig" ext=$IMAGELIST[image].ext}}" title="{{$LANG.view_full_image}}"><span style="text-align:right">{{$IMAGELIST[image].desc|truncate:17:'':true}}</a>
      <input type="checkbox" name="images[]" value="{{$IMAGELIST[image].desc}}.{{$IMAGELIST[image].ext}}" style="margin:0;padding:0" /></span><br />
      <img src="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}" alt="Image" title="{{$IMAGELIST[image].desc}}.{{$IMAGELIST[image].ext}}" />
      </label></div>
<div style="clear:left"></div>
</div>
{{sectionelse}}<div style="margin:10px"><span style="font-style:italic">{{$LANG.no_images|ucfirst}}</span></div>{{/section}}
{{if $IMAGELIST}}<div style="text-align:center"><input type="submit" value="  {{$LANG.delete_images}}Delete images  " /></div>
</form>{{/if}}
</div>
<div style="clear:left"></div>
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
	<p><input type="hidden" name="gallery" value="{{$smarty.get.gallery}}" /></p>
	<p><input type="submit" value="    {{$LANG.upload|ucfirst}}    " /></p>
</form>
</div>
</div>
