{{include file="gallery_goto.tpl"}}
<div style="margin:0;text-align:center;">
{{section name='image' loop=$IMAGELIST max=$IMP start=$START}}
<div class="image_gallery">
      <a href="{{LINK section=$IMAGELIST[image].uri script="gallery_image_orig" ext=$IMAGELIST[image].ext}}"
      class="highslide" id="group2" onclick="return hs.expand(this)" style="margin:0;padding:0">
      <img src="{{LINK section=$IMAGELIST[image].uri  script="gallery_image" ext=$IMAGELIST[image].ext}}" alt="Imagen" 
      title="Click to enlarge" style="margin:0;padding:0" /></a>
      <div class="highslide-heading">{{$IMAGELIST[image].desc}}</div>
<div style="clear:both"></div>
</div>
{{sectionelse}}<span style="font-style:italic">{{$LANG.no_images|ucfirst}}{{DYNAMIC}}{{if $IS_ADMIN}}{{$LANG.upload_admin|ucfirst}}{{/if}}{{/DYNAMIC}}</span>{{/section}}
</div>
<div style="clear:left"></div>
{{include file="gallery_goto.tpl"}}

