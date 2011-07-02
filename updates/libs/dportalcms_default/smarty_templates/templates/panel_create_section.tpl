  <div style="padding:10px">{{$LANG.create_section_warn}}</div>
  <div style="margin:auto;padding: 0 10px 0 10px;width:400px;margin:auto">
    <form method="post"
action="{{LINK script='panel' section='section:create' argument='?CREATE'}}">
      <div style="text-align:center">
        <select class="list" name="category" style="margin:0 0 10px 0;width:250px">
          <option class="list" selected="selected" disabled="disabled"
    value="">{{$LANG.select_category|ucfirst}}</option>
          {{section name="categories" loop=$CATEGORIES}}
    
          <option
    value="{{$CATEGORIES[categories].name}}">{{$CATEGORIES[categories].title}}
            ({{$CATEGORIES[categories].name}})</option>
          {{/section}}
  
        </select>
      </div>
      <div style="text-align:right"> <strong>{{$LANG.section_name|ucfirst}}:</strong>
          <input type="text"
  name="filename" value="" style="width:250px" />
      </div>
      <div style="text-align:right"> <strong>{{$LANG.title|ucfirst}}:</strong>
          <input type="text" name="title"
  value="" style="width:250px" />
      </div>
      <div style="text-align:center;padding: 10px">
        <input name="submit" type="submit" value="  Create!  " />
      </div>
    </form>
  </div>
