<script language="Javascript" type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/edit_area/edit_area_full.js"></script>
	<script language="Javascript" type="text/javascript">
	<!--//
		// initialisation
		editAreaLoader.init({
			id: "template_editor"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,word_wrap: false
			,language: "es"
			,syntax: "html"
			,toolbar: "save, search, go_to_line, |, undo, redo, |, word_wrap, highlight, reset_highlight, |, help"
			,save_callback: "save"
		});
		
		function toogle_editable(id)
		{
			editAreaLoader.execCommand(id, 'set_editable', !editAreaLoader.execCommand(id, 'is_editable'));
		}
		
		function save(id, content){
			document.template_editor_form.submit();
		}

	
	-->
	</script>
	