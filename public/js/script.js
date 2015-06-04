$(document).ready(function() {

	$(".alert.alert-danger")
	.css({
		'margin-top'		: '5px'
	}).find('li').css({
		'list-style-type'	: 'none'
	});

	var loc = window.location.pathname;
	loc =  loc.split('/')

	if (!loc[1]) 
	{
		$("#home").addClass('active');
	} else
	{
		$("#" + loc[1]).addClass('active');
	}
	
})
