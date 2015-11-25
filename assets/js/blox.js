jQuery(document).ready( function($) {
	
	var editor = ace.edit("blox-html");
    
    editor.session.setMode("ace/mode/html");
    editor.getSession().on('change', function(e) {
	   $('#_blox_html').val( editor.getValue() );
	});

});