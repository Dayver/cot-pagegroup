$(document).ready(function(){
	add_button_heandler();
});

function add_button_heandler()
{	$('#addextrfd button').click(function(){
		var extrfd_name = $('input[name="extrfldnamegroup"]').val();
		ajaxSend({url: 'index.php?r=pagegroup&a=addextfield&name='+extrfd_name, divId: 'addextrfd'});
		return false;
	});}