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

	$('#searchForm').submit(function(e)
	{
		var val = $('#search-field').val();
		e.preventDefault();

		if (val !== '') 
		{
			search(val);
		};
	})

	refresh();

	$("#postContainer").animate({
		scrollTop: $('#postContainer')[0].scrollHeight
	}, 3000);



	setInterval(function() {
		refresh();
//Materialize.toast("HALLO", 4000);
	}, 5000);
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
			$("#postContainer > .row").html(data);
		}
	});
}

function search(data)
{
	$.ajax(
	{
		type: "GET",
		url: "/setSearch?" + data,

		success: function(data)
		{
			window.location.replace("search");
		}
	});
}