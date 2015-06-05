$(document).ready(function() 
{

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
	
	$('#chatButton').on('click', function(e)
	{
		e.preventDefault();

		if ($('#textField').val() !== '') 
		{
			submitPost($('#textField').val());
		}
	})

	setInterval(function() {
		refresh();
	}, 2000);
})

function submitPost(post)
{
	$.ajax(
	{
		type: "GET",
		url: "/chat/post/" + id,
		data: post,

		success: function(data)
		{
			$('#textField').val('');
			refresh();
		}
	});
}

function refresh()
{
	$.ajax(
	{
		type: "GET",
		url: "/chat/refresh",

		success: function(data)
		{
			$("#postContainer").html(data);
		}
	});
}