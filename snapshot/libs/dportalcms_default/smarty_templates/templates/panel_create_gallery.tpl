<div>
  <div  style="text-align:left;padding:10px">{{$LANG.create_gallery_preface}}</div>

<div style="text-align:right;width:400px;margin:auto">

<form method="post"
action="{{LINK script='panel' section='gallery:create' argument='?CREATE_GALLERY'}}">

  <div>
  <strong>{{$LANG.name|ucfirst}}:</strong> <input type="text" name="name"
  style="width:250px" /></div>

  <div>
  <strong>{{$LANG.title|ucfirst}}</strong>: <input type="text" name="title"
  style="width:250px" /></div>

  <div style="text-align:center;margin-top:10px">
  <select style="width:85px" name="max">
    <option class="list" selected="selected"
    disabled="disabled">IMP</option>{{section name='max' loop=$MAX}}
    <option value="{{$MAX[max]}}">{{$MAX[max]}}</option>{{/section}}
  </select>
   
  <input type="submit" value="Create" /> </div>
</form>
</div>
</div>