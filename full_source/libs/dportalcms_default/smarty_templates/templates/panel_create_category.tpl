<div style="padding:10px">{{$LANG.create_category_warn}}</div>

<div style="margin:auto;width:400px">

<form  method="post"
action="{{if $smarty.const.DEMO_CPANEL === true}}{{LINK script='panel_demo' section='category:create' argument='?CREATE_CATEGORY'}}{{else}}{{LINK script='panel' section='category:create' argument='?CREATE_CATEGORY'}}{{/if}}">

  <div style="text-align:right">
  <div style="text-align:center"></div>
  <strong>{{$LANG.category_name|ucfirst}}:</strong> 
  <input type="text"
  name="name" value="" style="width:250px" /> </div>

  <div style="text-align:right">
  <strong>{{$LANG.category_title|ucfirst}}:</strong> <input type="text"
  name="title" value="" style="width:250px" /> </div>

  <div style="text-align:center;padding: 10px">

  <input type="submit" value="  Create!  " /></div>
</form>
</div>
